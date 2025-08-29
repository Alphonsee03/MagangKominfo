<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PembelianStok;
use App\Models\DetailPembelian;
use App\Models\Supplier;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\SupplierProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PembelianStokController extends Controller
{
    public function index()
    {
        $pembelians = PembelianStok::with('supplier')->latest()->paginate(10);
        return view('admin.pembelianstok.index', compact('pembelians'));
    }

    public function create()
    {
        $suppliers  = Supplier::orderBy('nama')->get(['id', 'nama']);
        $kategoris  = Kategori::orderBy('nama')->get(['id', 'nama']); // <-- kirim ke view
        return view('admin.pembelianstok.create', compact('suppliers', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'produk_id'   => 'required|array|min:1',
            'produk_id.*' => 'required|exists:supplier_produks,id',
            'jumlah'      => 'required|array',
        ]);


        Log::info('STORE PEMBELIAN', $request->all());

        DB::beginTransaction();
        try {
            $pembelian = PembelianStok::create([
                'supplier_id' => $request->supplier_id,
                'tanggal'     => now(),
                'total'       => 0,
            ]);

            $grandTotal = 0;

            foreach ($request->produk_id as $supplierProdukId) {
                $jumlah = (int) ($request->jumlah[$supplierProdukId] ?? 0);

                if ($jumlah <= 0) continue; // skip kalau tidak diisi

                $supplierProduk = SupplierProduk::with('kategori', 'supplier')->findOrFail($supplierProdukId);

                $harga    = $supplierProduk->harga_beli;
                $subtotal = $harga * $jumlah;
                $grandTotal += $subtotal;

                DetailPembelian::create([
                    'pembelian_stok_id' => $pembelian->id,
                    'produk_id'         => $supplierProdukId,
                    'jumlah'            => $jumlah,
                    'harga_beli'        => $harga,
                    'subtotal'          => $subtotal,
                ]);

                // update stok gudang
                $produkGudang = Produk::firstOrCreate(
                    ['kode_produk' => 'SP-' . $supplierProduk->id],
                    [
                        'kategori_id' => $supplierProduk->kategori_id,
                        'nama'        => $supplierProduk->nama,
                        'harga_beli'  => $supplierProduk->harga_beli,
                        'harga_jual'  => $supplierProduk->harga_beli * 1.2,
                        'stok'        => 0,
                        'deskripsi'   => 'Import dari supplier: ' . $supplierProduk->supplier->nama,
                    ]
                );

                $produkGudang->increment('stok', $jumlah);
            }


            $pembelian->update(['total' => $grandTotal]);

            DB::commit();
            return redirect()->route('admin.pembelians.index')
                ->with('success', 'Pembelian berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Gagal menyimpan pembelian: ' . $e->getMessage());
        }
    }


    public function destroy(PembelianStok $pembelian)
    {
        // Kurangi stok produk berdasarkan detail pembelian
        foreach ($pembelian->detailPembelians as $detail) {
            $produk = Produk::find($detail->produk_id);
            if ($produk) {
                $produk->stok -= $detail->jumlah;
                if ($produk->stok < 0) {
                    $produk->stok = 0; // jaga-jaga stok jangan minus
                }
                $produk->save();
            }
        }

        // Hapus detail pembelian
        $pembelian->detailPembelians()->delete();

        // Hapus header pembelian
        $pembelian->delete();

        return redirect()->route('admin.pembelians.index')
            ->with('success', 'Pembelian berhasil dihapus dan stok produk dikurangi.');
    }

    public function show(PembelianStok $pembelian)
    {
        $pembelian->load('supplier', 'details.produk');
        return view('admin.pembelianstok.show', compact('pembelian'));
    }

    public function getSupplierProduk(Request $r)
    {
        return SupplierProduk::query()
            ->where('supplier_id', $r->supplier_id)
            ->when($r->kategori_id, fn($q) => $q->where('kategori_id', $r->kategori_id))
            ->get(['id', 'nama', 'harga_beli', 'stok_supplier']);
    }
}
