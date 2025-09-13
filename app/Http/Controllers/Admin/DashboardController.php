<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\StokLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function years()
    {
        $years = DB::table('transaksis')
            ->selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderBy('year', 'asc')
            ->pluck('year');

        return response()->json($years);
    }


    public function data(Request $request)
    {
        try {
            $periode = $request->get('periode', 'all');   // minggu|bulan|tahun|all
            $tahun   = $request->get('tahun') ?? now()->year;

            // periode boundaries (dipakai untuk cards & beberapa query)
            if ($periode === 'minggu' || $periode === 'bulan') {
                $periodStart = Carbon::create($tahun, 1, 1)->startOfYear();
                $periodEnd   = Carbon::create($tahun, 12, 31)->endOfYear();
            } elseif ($periode === 'tahun') {
                $periodStart = DB::table('transaksis')->min('created_at') ? Carbon::parse(DB::table('transaksis')->min('created_at')) : Carbon::create(2024, 1, 1);
                $periodEnd   = Carbon::now()->endOfYear();
            } else { // all
                $minCreated = DB::table('transaksis')->min('created_at');
                $periodStart = $minCreated ? Carbon::parse($minCreated) : Carbon::create(2024, 2, 1);
                $periodEnd   = Carbon::now();
            }

            // --- Cards (omzet/profit/transaksi/produk/pembelian) ---
            $cards = DB::table('detail_transaksis')
                ->join('produks', 'produks.id', '=', 'detail_transaksis.produk_id')
                ->join('transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
                ->whereBetween('transaksis.created_at', [$periodStart, $periodEnd])
                ->selectRaw("
                COALESCE(SUM(detail_transaksis.jumlah * detail_transaksis.harga_jual),0) as total_omzet,
                COALESCE(SUM(detail_transaksis.jumlah * produks.harga_beli),0) as total_modal,
                COUNT(DISTINCT transaksis.id) as total_transaksi,
                COALESCE(SUM(detail_transaksis.jumlah),0) as total_produk,
                COALESCE(SUM(produks.harga_beli * detail_transaksis.jumlah),0) as total_pembelian
            ")
                ->first();

            // --- Chart ---
            $chart = [
                'labels' => [],
                'omzet'  => [],
                'profit' => [],
            ];

            if ($periode === 'minggu') {
                // gunakan YEARWEEK agar konsisten, ambil min/max tanggal tiap grup untuk label range
                $chartRows = DB::table('detail_transaksis')
                    ->join('produks', 'produks.id', '=', 'detail_transaksis.produk_id')
                    ->join('transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
                    ->selectRaw("
                    COALESCE(SUM(detail_transaksis.jumlah * detail_transaksis.harga_jual),0) as omzet,
                    COALESCE(SUM(detail_transaksis.jumlah * produks.harga_beli),0) as modal,
                    YEARWEEK(transaksis.created_at, 3) as yw,
                    MIN(transaksis.created_at) as week_start,
                    MAX(transaksis.created_at) as week_end
                ")
                    ->whereYear('transaksis.created_at', $tahun)
                    ->groupBy('yw')
                    ->orderBy('week_start', 'asc')
                    ->get();

                // build labels & data — hanya minggu yang punya data (lebih rapi)
                foreach ($chartRows as $row) {
                    $s = Carbon::parse($row->week_start);
                    $e = Carbon::parse($row->week_end);

                    // Label: "Jan:01-07"
                    $label = $s->format('M:d') . '-' . $e->format('d');

                    $chart['labels'][] = $label;
                    $chart['omzet'][]  = (float) $row->omzet;
                    $chart['profit'][] = (float) ($row->omzet - $row->modal);
                }
            } elseif ($periode === 'bulan') {
                $selects = [
                    DB::raw("YEAR(transaksis.created_at) as g_year"),
                    DB::raw("MONTH(transaksis.created_at) as g_month"),
                    DB::raw("DATE_FORMAT(transaksis.created_at, '%b') as label"),
                    DB::raw("COALESCE(SUM(detail_transaksis.jumlah * detail_transaksis.harga_jual),0) as omzet"),
                    DB::raw("COALESCE(SUM(detail_transaksis.jumlah * produks.harga_beli),0) as modal"),
                    DB::raw("MIN(transaksis.created_at) as sort_date"),
                ];

                $rows = DB::table('detail_transaksis')
                    ->join('produks', 'produks.id', '=', 'detail_transaksis.produk_id')
                    ->join('transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
                    ->select($selects)
                    ->whereBetween('transaksis.created_at', [$periodStart, $periodEnd])
                    ->groupBy(['g_year', 'g_month', 'label'])
                    ->orderBy('sort_date', 'asc')
                    ->get();

                foreach ($rows as $r) {
                    $chart['labels'][] = $r->label;
                    $chart['omzet'][]  = (float) $r->omzet;
                    $chart['profit'][] = (float) ($r->omzet - $r->modal);
                }
            } elseif ($periode === 'tahun') {
                $rows = DB::table('detail_transaksis')
                    ->join('produks', 'produks.id', '=', 'detail_transaksis.produk_id')
                    ->join('transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
                    ->selectRaw("
                    YEAR(transaksis.created_at) as label,
                    COALESCE(SUM(detail_transaksis.jumlah * detail_transaksis.harga_jual),0) as omzet,
                    COALESCE(SUM(detail_transaksis.jumlah * produks.harga_beli),0) as modal,
                    MIN(transaksis.created_at) as sort_date
                ")
                    ->whereBetween('transaksis.created_at', [$periodStart, $periodEnd])
                    ->groupBy('label')
                    ->orderBy('sort_date', 'asc')
                    ->get();

                foreach ($rows as $r) {
                    $chart['labels'][] = (string) $r->label;
                    $chart['omzet'][]  = (float) $r->omzet;
                    $chart['profit'][] = (float) ($r->omzet - $r->modal);
                }
            } else {
                // all -> group by month across years (e.g. "Feb 2024", "Mar 2024", ...)
                $selects = [
                    DB::raw("YEAR(transaksis.created_at) as g_year"),
                    DB::raw("MONTH(transaksis.created_at) as g_month"),
                    DB::raw("DATE_FORMAT(transaksis.created_at, '%b %Y') as label"),
                    DB::raw("COALESCE(SUM(detail_transaksis.jumlah * detail_transaksis.harga_jual),0) as omzet"),
                    DB::raw("COALESCE(SUM(detail_transaksis.jumlah * produks.harga_beli),0) as modal"),
                    DB::raw("MIN(transaksis.created_at) as sort_date"),
                ];

                $rows = DB::table('detail_transaksis')
                    ->join('produks', 'produks.id', '=', 'detail_transaksis.produk_id')
                    ->join('transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
                    ->select($selects)
                    ->whereBetween('transaksis.created_at', [$periodStart, $periodEnd])
                    ->groupBy(['g_year', 'g_month', 'label'])
                    ->orderBy('sort_date', 'asc')
                    ->get();

                foreach ($rows as $r) {
                    $chart['labels'][] = $r->label;
                    $chart['omzet'][]  = (float) $r->omzet;
                    $chart['profit'][] = (float) ($r->omzet - $r->modal);
                }
            }

            // === Produk Terlaris (top 5 by qty) ===
            $produkTerlaris = DB::table('detail_transaksis')
                ->join('produks', 'produks.id', '=', 'detail_transaksis.produk_id')
                ->join('transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
                ->whereBetween('transaksis.created_at', [$periodStart, $periodEnd])
                ->select('produks.nama', DB::raw('COALESCE(SUM(detail_transaksis.jumlah),0) as jumlah'))
                ->groupBy('produks.id', 'produks.nama')
                ->orderByDesc('jumlah')
                ->limit(5)
                ->get();

            // === Supplier Terbanyak (sum stok masuk per supplier via pivot produk_supplier) ===
            $supplierTerbanyak = DB::table('produk_supplier')
                ->join('suppliers', 'suppliers.id', '=', 'produk_supplier.supplier_id')
                ->join('stok_logs', 'stok_logs.produk_id', '=', 'produk_supplier.produk_id')
                ->select('suppliers.nama', DB::raw('COALESCE(SUM(stok_logs.jumlah),0) as total'))
                ->where('stok_logs.tipe', 'masuk')
                ->whereBetween('stok_logs.created_at', [$periodStart, $periodEnd])
                ->groupBy('suppliers.id', 'suppliers.nama')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            // === Transaksi tertinggi (top 10 by total) ===
            $transaksiTertinggi = DB::table('transaksis')
                ->join('detail_transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
                ->whereBetween('transaksis.created_at', [$periodStart, $periodEnd])
                ->select('transaksis.invoice', DB::raw('COALESCE(SUM(detail_transaksis.jumlah * detail_transaksis.harga_jual),0) as total'))
                ->groupBy('transaksis.id', 'transaksis.invoice')
                ->orderByDesc('total')
                ->limit(10)
                ->get();



            // === Stok kritis (Top 10 stok terendah) ===
            $stokKritis = DB::table('produks')
                ->select('nama', 'stok')
                ->orderBy('stok', 'asc')
                ->limit(10)
                ->get();



            // daftar tahun untuk convenience (frontend kadang butuh)
            $years = DB::table('transaksis')
                ->selectRaw('DISTINCT YEAR(created_at) as year')
                ->orderBy('year', 'desc')
                ->pluck('year');

                
            return response()->json([
                'cards' => [
                    'total_omzet'     => (float) ($cards->total_omzet ?? 0),
                    'total_profit'    => (float) (($cards->total_omzet ?? 0) - ($cards->total_modal ?? 0)),
                    'total_transaksi' => (int) ($cards->total_transaksi ?? 0),
                    'total_produk'    => (int) ($cards->total_produk ?? 0),
                    'total_pembelian' => (float) ($cards->total_pembelian ?? 0),
                ],
                'chart' => $chart,
                'produk_terlaris'     => $produkTerlaris,
                'supplier_terbanyak'  => $supplierTerbanyak,
                'transaksi_tertinggi' => $transaksiTertinggi,
                'stok_kritis'         => $stokKritis,
                'years'               => $years,
            ]);
        } catch (\Throwable $e) {
            // Debug friendly response (remove trace on production)
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
}
