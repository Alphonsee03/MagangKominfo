<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class LaporanProfitController extends Controller
{
    public function index()
    {
        return view('admin.laporan.profit.profit');
    }

    public function data(Request $request)
    {
        $query = DetailTransaksi::with(['produk', 'transaksi.user']);

        if ($request->start_date) {
            $query->whereHas('transaksi', function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->start_date);
            });
        }

        if ($request->end_date) {
            $query->whereHas('transaksi', function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->end_date);
            });
        }

        $details = $query->get();

        $total_penjualan = 0;
        $total_modal = 0;

        $rows = $details->map(function ($d) use (&$total_penjualan, &$total_modal) {
            $subtotal_penjualan = $d->jumlah * $d->harga_jual;
            $subtotal_modal = $d->jumlah * $d->produk->harga_beli;

            $total_penjualan += $subtotal_penjualan;
            $total_modal += $subtotal_modal;

            return [
                'invoice'   => $d->transaksi->invoice ?? '-',
                'tanggal'   => $d->transaksi->created_at->format('d-m-Y H:i'),
                'kasir'     => $d->transaksi->user->nama ?? '-',
                'produk'    => $d->produk->nama ?? '-',
                'qty'       => $d->jumlah,
                'harga_beli'=> $d->produk->harga_beli,
                'harga_jual'=> $d->harga_jual,
                'subtotal'  => $subtotal_penjualan,
                'profit'    => $subtotal_penjualan - $subtotal_modal,
            ];
        });

        return response()->json([
            'summary' => [
                'total_penjualan' => $total_penjualan,
                'total_modal'     => $total_modal,
                'profit'          => $total_penjualan - $total_modal,
                'total_transaksi' => $details->count(),
            ],
            'data' => $rows,
        ]);
    }

    public function exportPdf(Request $request)
{
    $query = DetailTransaksi::with(['produk', 'transaksi.user']);

    if ($request->start_date) {
        $query->whereHas('transaksi', fn($q) => $q->whereDate('created_at', '>=', $request->start_date));
    }

    if ($request->end_date) {
        $query->whereHas('transaksi', fn($q) => $q->whereDate('created_at', '<=', $request->end_date));
    }

    $details = $query->get();

    $total_penjualan = 0;
    $total_modal = 0;

    $rows = $details->map(function ($d) use (&$total_penjualan, &$total_modal) {
        $subtotal_penjualan = $d->jumlah * $d->harga_jual;
        $subtotal_modal = $d->jumlah * $d->produk->harga_beli;

        $total_penjualan += $subtotal_penjualan;
        $total_modal += $subtotal_modal;

        return [
            'invoice'   => $d->transaksi->invoice ?? '-',
            'tanggal'   => $d->transaksi->created_at->format('d-m-Y H:i'),
            'kasir'     => $d->transaksi->user->nama ?? '-',
            'produk'    => $d->produk->nama ?? '-',
            'qty'       => $d->jumlah,
            'harga_beli'=> $d->produk->harga_beli,
            'harga_jual'=> $d->harga_jual,
            'subtotal'  => $subtotal_penjualan,
            'profit'    => $subtotal_penjualan - $subtotal_modal,
        ];
    });

    $summary = [
        'total_penjualan' => $total_penjualan,
        'total_modal'     => $total_modal,
        'profit'          => $total_penjualan - $total_modal,
        'total_transaksi' => $details->count(),
    ];

    $html = view('admin.laporan.profit.pdf', [
        'rows'       => $rows,
        'summary'    => $summary,
        'start_date' => $request->start_date,
        'end_date'   => $request->end_date,
    ])->render();

    $mpdf = new Mpdf(['orientation' => 'L']); // L = Landscape, P = Portrait (default)

    $mpdf->WriteHTML($html);
    return $mpdf->Output("laporan_profit.pdf", "I");
}
}
