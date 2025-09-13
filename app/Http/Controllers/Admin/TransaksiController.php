<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Mpdf\Mpdf;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('admin.transaksi.index');
    }

    public function data(Request $request)
    {
        $query = Transaksi::with(['user', 'pelanggan'])
            ->orderBy('created_at', 'desc');

        // filter tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // filter metode
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        // search invoice / pelanggan / kasir
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice', 'like', "%{$search}%")
                    ->orWhereHas('pelanggan', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        $transaksis = $query->paginate(15);

        return response()->json($transaksis);
    }


    public function detail($id)
    {
        $transaksi = Transaksi::with(['user', 'pelanggan', 'details.produk'])->findOrFail($id);

        return response()->json([
            'invoice'   => $transaksi->invoice,
            'tanggal'   => $transaksi->created_at->format('d-m-Y H:i'),
            'kasir'     => $transaksi->user?->nama ?? '-',
            'pelanggan' => $transaksi->pelanggan?->nama ?? 'Umum',
            'metode'    => $transaksi->metode_pembayaran,
            'total'     => $transaksi->total,
            'diskon'    => $transaksi->diskon ?? 0,
            'bayar'     => $transaksi->bayar,
            'kembali'   => $transaksi->kembali,
            'items'     => $transaksi->details->map(fn($d) => [
                'produk'   => $d->produk->nama,
                'kode'     => $d->produk->kode_produk,
                'qty'      => $d->jumlah,
                'harga'    => $d->harga_jual,
                'subtotal' => $d->subtotal,
            ])
        ]);
    }




    public function exportPdf(Request $request)
    {
        $start = $request->get('start_date');
        $end   = $request->get('end_date');
        $metode = $request->get('metode');
        $search = $request->get('search');

        $query = Transaksi::with(['user', 'pelanggan'])
            ->when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('created_at', '<=', $end))
            ->when($metode, fn($q) => $q->where('metode_pembayaran', $metode))
            ->when($search, function ($q) use ($search) {
                $q->where('invoice', 'like', "%$search%")
                    ->orWhereHas('pelanggan', fn($p) => $p->where('nama', 'like', "%$search%"))
                    ->orWhereHas('user', fn($u) => $u->where('nama', 'like', "%$search%"));
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $summary = [
            'jumlah_transaksi' => $query->count(),
            'omzet' => $query->sum('total'),
            'total_bayar' => $query->sum('bayar'),
            'total_kembali' => $query->sum('kembali'),
        ];
        $mpdf = new Mpdf(['orientation' => 'L']);
        $html = view('admin.transaksi.export-pdf', [
            'transaksis' => $query,
            'summary' => $summary,
            'start_date' => $start,
            'end_date' => $end,
        ])->render();
        
        
        $mpdf->WriteHTML($html);
        return $mpdf->Output("laporan-transaksi.pdf", "I");
    }


    public function exportDetailPdf($id)
    {
        $transaksi = Transaksi::with(['user', 'pelanggan', 'details.produk'])->findOrFail($id);

        $html = view('admin.transaksi.detail-pdf', compact('transaksi'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output("detail-{$transaksi->invoice}.pdf", 'I');
    }

}
