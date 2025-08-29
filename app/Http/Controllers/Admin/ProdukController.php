<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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




    /**
     * Menampilkan form tambah produk
     */
    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get(['id', 'nama']);
        $suppliers = Supplier::orderBy('nama')->get(['id', 'nama']);
        return view('admin.produks.create', compact('kategoris', 'suppliers'));
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        Log::info('Store Request:', $request->all());

        $request->validate([
            'suppliers' => 'required|array',
            'suppliers.*' => 'exists:suppliers,id',
            'kode_produk' => 'required|string|max:100|unique:produks',
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('suppliers');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk = Produk::create($data);

        // Attach suppliers
        $produk->suppliers()->attach($request->suppliers);

        // Jika request via AJAX
        if ($request->ajax()) {
            $produk->load(['kategori', 'suppliers']);
            return response()->json([
                'success' => true,
                'produk' => $produk,
                'kategori_nama' => $produk->kategori->nama ?? '-',
                'message' => 'Produk berhasil disimpan!'
            ]);
        }

        // Jika request normal
        return redirect()
            ->route('admin.produks.index')
            ->with('success', 'Produk berhasil ditambahkan.');
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
            'suppliers' => 'required|array',
            'suppliers.*' => 'exists:suppliers,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_produk' => 'required|string|max:100|unique:produks,kode_produk,' . $produk->id,
            'nama'        => 'required|string|max:255',
            'harga_beli'  => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('suppliers');

        if ($request->hasFile('foto')) {
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk->update($data);

        // Sync suppliers
        $produk->suppliers()->sync($request->suppliers);


        $produk->load(['kategori', 'suppliers']);
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diperbarui!',
            'data' => [
                'id' => $produk->id,
                'kode_produk' => $produk->kode_produk,
                'nama' => $produk->nama,
                'kategori_id' => $produk->kategori_id,
                'kategori_nama' => $produk->kategori->nama ?? null,
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
        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }
        $produk->delete();

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
            'stok' => 'required|integer|min:1', // Ubah dari 'jumlah' ke 'stok'
        ]);

        $produk->increment('stok', $request->stok);

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil ditambahkan!',
            'stok_baru' => $produk->stok
        ]);
    }
}
