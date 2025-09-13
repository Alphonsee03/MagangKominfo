<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\StokLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk
     */
    public function index(Request $request)
    {
        $query = Produk::with(['kategori', 'suppliers']); // Menggunakan 'suppliers' untuk relasi many-to-many

        if ($request->search) {
            $query->where('nama', 'like', "%{$request->search}%");
        }
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->supplier_id) {
            // Menggunakan whereHas untuk memfilter berdasarkan supplier_id
            $query->whereHas('suppliers', function ($query) use ($request) {
                $query->where('supplier_id', $request->supplier_id);
            });
        }

        $produks = $query->paginate(15);

        if ($request->ajax()) {
            return view('admin.produks._table', compact('produks'))->render();
        }

        $kategoris = Kategori::all();
        $suppliers = Supplier::all();

        return view('admin.produks.index', compact('produks', 'kategoris', 'suppliers'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get(['id', 'nama']);
        $suppliers = Supplier::orderBy('nama')->get(['id', 'nama']);
        return view('admin.produks.create', compact('kategoris', 'suppliers'));
    }


    public function store(Request $request)
    {
        Log::info('Store Request:', $request->all());

        // Cek apakah request multiple (manual) atau single (AJAX)
        $isAjax = $request->ajax();

        if ($isAjax) {
            // --- VALIDASI SINGLE PRODUK ---
            $request->validate([
                'suppliers'    => 'required|array',
                'suppliers.*'  => 'exists:suppliers,id',
                'kode_produk'  => 'required|string|max:15|unique:produks',
                'nama'         => 'required|string|max:255',
                'kategori_id'  => 'required|exists:kategoris,id',
                'harga_beli'   => 'required|numeric|min:0',
                'harga_jual'   => 'required|numeric|min:0',
                'stok'         => 'required|integer|min:0',
                'deskripsi'    => 'nullable|string',
                'foto'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $produk = $this->storeSingle($request);

            // --- RETURN JSON untuk AJAX ---
            $produk->load(['kategori', 'suppliers']);
            return response()->json([
                'success' => true,
                'produk' => $produk,
                'kategori_nama' => $produk->kategori->nama ?? '-',
                'message' => 'Produk berhasil disimpan!'
            ]);
        } else {
            // --- VALIDASI MULTIPLE PRODUK ---
            $request->validate([
                'products'                   => 'required|array',
                'products.*.suppliers'       => 'required|array',
                'products.*.suppliers.*'     => 'exists:suppliers,id',
                'products.*.kode_produk'     => 'required|string|max:15|unique:produks,kode_produk',
                'products.*.nama'            => 'required|string|max:255',
                'products.*.kategori_id'     => 'required|exists:kategoris,id',
                'products.*.harga_beli'      => 'required|numeric|min:0',
                'products.*.harga_jual'      => 'required|numeric|min:0',
                'products.*.stok'            => 'required|integer|min:0',
                'products.*.deskripsi'       => 'nullable|string',
                'products.*.foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            DB::beginTransaction();
            try {
                foreach ($request->products as $productData) {
                    $this->storeSingle(new Request($productData));
                }
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Gagal simpan produk: ' . $e->getMessage()]);
            }

            return redirect()
                ->route('admin.produks.index')
                ->with('success', 'Semua produk berhasil ditambahkan.');
        }
    }

    private function storeSingle(Request $request)
    {
        $data = $request->except('suppliers');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk = Produk::create($data);

        // Relasi supplier
        $produk->suppliers()->attach($request->suppliers);

        // Stok awal
        if ($produk->stok > 0) {
            StokLog::create([
                'produk_id'  => $produk->id,
                'tipe'       => 'masuk',
                'jumlah'     => $produk->stok,
                'keterangan' => 'Input Produk ' . $produk->nama,
                'user_id'    => Auth::guard('admin')->id() ?? Auth::id(),
            ]);
        }

        return $produk;
    }



    /**
     * Menampilkan form edit produk
     */
    public function edit(Produk $produk)
    {
        $kategoris = Kategori::all();
        return view('admin.produks.edit', compact('produk', 'kategoris'));
    }

    /**
     * Update data produk
     */
    public function update(Request $request, Produk $produk)
    {
        Log::info('Update Request:', $request->all());

        $request->validate([
            'suppliers'    => 'required|array',
            'suppliers.*'  => 'exists:suppliers,id',
            'kategori_id'  => 'required|exists:kategoris,id',
            'kode_produk'  => 'required|string|max:15|unique:produks,kode_produk,' . $produk->id,
            'nama'         => 'required|string|max:255',
            'harga_beli'   => 'required|numeric|min:0',
            'harga_jual'   => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except('suppliers');

            if ($request->hasFile('foto')) {
                if ($produk->foto) {
                    Storage::disk('public')->delete($produk->foto);
                }
                $data['foto'] = $request->file('foto')->store('produk', 'public');
            }

            $stokLama = $produk->stok;

            $produk->update($data);

            // Update relasi supplier
            $produk->suppliers()->sync($request->suppliers);

            // Catat perubahan stok jika ada perbedaan
            $delta = $produk->stok - $stokLama;
            if ($delta !== 0) {
                StokLog::create([
                    'produk_id'  => $produk->id,
                    'tipe'       => $delta > 0 ? 'masuk' : 'keluar',
                    'jumlah'     => abs($delta),
                    'keterangan' => 'Penyesuaian stok' . $produk->nama,
                    'user_id'    => Auth::guard('admin')->id() ?? Auth::id(),
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal update produk: ' . $e->getMessage()]);
        }
        $produk->load(['kategori', 'suppliers']);
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diperbarui!',
            'data' => [
                'id' => $produk->id,
                'kode_produk' => $produk->kode_produk,
                'nama' => $produk->nama,
                'kategori' => [
                    'id' => $produk->kategori->id ?? null,
                    'nama' => $produk->kategori->nama ?? null,
                ],
                'harga_beli' => $produk->harga_beli,
                'harga_jual' => $produk->harga_jual,
                'stok' => $produk->stok,
                'deskripsi' => $produk->deskripsi,
                'suppliers' => $produk->suppliers->pluck('id')->toArray()
            ]
        ]);
    }


    /**
     * Hapus produk
     */
    public function destroy(Produk $produk)
    {
        DB::beginTransaction();
        try {
            // Catat keluar semua stok jika masih ada
            if ($produk->stok > 0) {
                StokLog::create([
                    'produk_id'  => $produk->id,
                    'tipe'       => 'keluar',
                    'jumlah'     => $produk->stok,
                    'keterangan' => 'hapus/retur produk' . $produk->nama,
                    'user_id'    => Auth::guard('admin')->id() ?? Auth::id(),
                ]);
            }

            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }

            // Hapus relasi supplier
            $produk->suppliers()->detach();

            // Hapus produk
            $produk->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal hapus produk: ' . $e->getMessage()]);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.produks.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Update stok via AJAX
     */
    public function updateStok(Request $request, Produk $produk)
    {
        $request->validate([
            'stok' => 'required|integer|min:1',
        ]);

        $produk->increment('stok', $request->stok);

        StokLog::create([
            'produk_id'     => $produk->id,
            'tipe'          => 'masuk',
            'jumlah'        => $request->stok,
            'keterangan'    => 'Tambah stok' . $produk->nama,
            'transaksi_id'  => null,
            'user_id'       => auth('admin')->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil ditambahkan!',
            'stok_baru' => $produk->stok
        ]);
    }
}
