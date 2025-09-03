<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class LaporanController extends Controller
{
    public function stokGudang(Request $request)
    {
        $suppliers = Supplier::all();
        return view('admin.laporan.stok_gudang.stok-gudang', compact('suppliers'));
    }

    public function stokGudangData(Request $request)
    {
        $query = Produk::with('suppliers');

        if ($request->supplier_id) {
            $query->whereHas('suppliers', function($q) use ($request) {
                $q->where('suppliers.id', $request->supplier_id);
            });
        }

        $produks = $query->get()->map(function ($p) {
            return [
                'kode_produk' => $p->kode_produk,
                'nama'        => $p->nama,
                'stok'        => $p->stok,
                'harga_beli'  => $p->harga_beli,
                'harga_jual'  => $p->harga_jual,
                'nilai_stok'  => $p->stok * $p->harga_beli,
                'suppliers'   => $p->suppliers->pluck('nama')->implode(', '),
            ];
        });

        return response()->json($produks);
    }

    public function stokGudangExportPdf(Request $request)
    {
        $query = Produk::with('suppliers');

        if ($request->supplier_id) {
            $query->whereHas('suppliers', function($q) use ($request) {
                $q->where('suppliers.id', $request->supplier_id);
            });
        }

        $produks = $query->get();

        $html = view('admin.laporan.stok_gudang.pdf.stok-gudang', compact('produks'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output("laporan-stok-gudang.pdf", "I");
    }
}
