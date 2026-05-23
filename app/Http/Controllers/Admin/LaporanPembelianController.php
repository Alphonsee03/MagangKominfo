<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\StokLog;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class LaporanPembelianController extends Controller
{
    /**
     * Tampilan awal laporan pembelian
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('nama')->get();
        return view('admin.laporan.pembelian_stok.index', compact('suppliers'));
    }

    /**
     * Data laporan pembelian (AJAX)
     */
    public function data(Request $request)
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSort = ['id', 'jumlah', 'harga_beli', 'subtotal', 'created_at'];

        if (!in_array($sortBy, $allowedSort)) {
            $sortBy = 'created_at';
        }
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query = StokLog::with(['produk', 'produk.suppliers'])
            ->where('tipe', 'masuk'); // hanya stok masuk yg dianggap pembelian

        // Filter tanggal
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter supplier
        if ($request->supplier_id) {
            $query->whereHas('produk.suppliers', function ($q) use ($request) {
                $q->where('suppliers.id', $request->supplier_id);
            });
        }

        if ($sortBy === 'subtotal') {
            $query->orderByRaw('(stok_logs.jumlah * (SELECT harga_beli FROM produks WHERE produks.id = stok_logs.produk_id)) ' . $sortOrder);
        } elseif ($sortBy === 'harga_beli') {
            $query->orderByRaw('(SELECT harga_beli FROM produks WHERE produks.id = stok_logs.produk_id) ' . $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $logs = $query->get();

        // Mapping data untuk tabel
        $data = $logs->map(function ($log) {
            $produk = $log->produk;
            return [
                'tanggal'   => $log->created_at->format('d-m-Y'),
                'produk'    => $produk->nama ?? '-',
                'kode'      => $produk->kode_produk ?? '-',
                'supplier'  => $produk?->suppliers?->pluck('nama')?->join(', ') ?? '-',
                'jumlah'    => $log->jumlah,
                'harga_beli'=> $produk->harga_beli ?? 0,
                'subtotal'  => $log->jumlah * ($produk->harga_beli ?? 0),
                'keterangan'=> $log->keterangan,
            ];
        });

        return response()->json(['data' => $data]);
    }

    /**
     * Export laporan pembelian ke PDF
     */
    public function exportPdf(Request $request)
    {
        $query = StokLog::with(['produk', 'produk.suppliers'])
            ->where('tipe', 'masuk');

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->supplier_id) {
            $query->whereHas('produk.suppliers', function ($q) use ($request) {
                $q->where('suppliers.id', $request->supplier_id);
            });
        }

        $logs = $query->latest()->get();

        // Data untuk ringkasan
        $total_item = $logs->sum('jumlah');
        $total_nominal = $logs->sum(function ($log) {
            return $log->jumlah * ($log->produk->harga_beli ?? 0);
        });

        $html = view('admin.laporan.pembelian_stok.pdf', [
            'logs' => $logs,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_item' => $total_item,
            'total_nominal' => $total_nominal,
        ])->render();

        $mpdf = new Mpdf(['orientation' => 'L']);
        $mpdf->WriteHTML($html);
        return $mpdf->Output('laporan-pembelian.pdf', 'I');
    }
}
