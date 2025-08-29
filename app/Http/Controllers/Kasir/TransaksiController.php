<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Helpers\InvoiceGenerator;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\StokLog;
use Carbon\Carbon;
use Mpdf\Mpdf;

class TransaksiController extends Controller
{
    public function history()
    {
        return view('kasir.riwayat.history');
    }


    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            // JSON error jika AJAX (kita memang pakai AJAX)
            return response()->json(['error' => 'Cart masih kosong'], 400);
        }

        // validasi dasar
        $request->validate([
            'bayar'              => 'required|numeric|min:0',
            'diskon'             => 'nullable|numeric|min:0',
            'metode_pembayaran'  => 'required|in:cash,qris',
            'pelanggan_id'       => 'nullable|exists:pelanggans,id',
        ]);

        // baca diskon dengan benar (null jika kosong)
        $rawDiskon = $request->input('diskon');
        $diskon = ($rawDiskon === null || $rawDiskon === '') ? null : (float) $rawDiskon;

        $total  = array_sum(array_column($cart, 'subtotal'));
        $grand  = max(0, $total - ($diskon ?? 0));

        if ((float)$request->bayar < $grand) {
            return response()->json(['error' => 'Jumlah bayar kurang dari total (Rp ' . number_format($grand, 0, ',', '.') . ')'], 400);
        }

        DB::beginTransaction();
        try {
            // buat transaksi
            $transaksi = Transaksi::create([
                'invoice'           => InvoiceGenerator::generate(),
                'user_id'           => Auth::guard('kasir')->id(),
                'pelanggan_id'      => $request->pelanggan_id,
                'tanggal'           => Carbon::today(),
                'total'             => $total,
                'diskon'            => $diskon,
                'bayar'             => $request->bayar,
                'kembali'           => $request->bayar - $grand,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status'            => 'lunas',
            ]);

            // detail transaksi + kurangi stok + log stok
            foreach ($cart as $item) {
                $produk = Produk::where('id', $item['produk_id'])->lockForUpdate()->first();
                if (!$produk) {
                    throw new \RuntimeException('Produk tidak ditemukan saat checkout.');
                }
                if ($produk->stok < $item['qty']) {
                    throw new \RuntimeException("Stok {$produk->nama} tidak cukup.");
                }

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $produk->id,
                    'jumlah'       => $item['qty'],
                    'harga_jual'   => $item['harga'],
                    'subtotal'     => $item['subtotal'],
                ]);

                $produk->decrement('stok', $item['qty']);

                StokLog::create([
                    'produk_id'    => $produk->id,
                    'tipe'         => 'keluar',
                    'jumlah'       => $item['qty'],
                    'keterangan'   => 'Penjualan',
                    'transaksi_id' => $transaksi->id,
                    'user_id'      => Auth::guard('kasir')->id(),
                ]);
            }

            DB::commit();
            session()->forget('cart');

            // RETURN JSON sukses (AJAX)
            return response()->json([
                'success' => 'Transaksi berhasil',
                'invoice' => $transaksi->invoice,
                'kembali' => $transaksi->kembali,
                'invoice_url' => route('kasir.transaksi.invoice', $transaksi->id),
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();

            // jika error karena stok/validasi runtime -> kirim pesan yang jelas
            $msg = $e->getMessage();

            return response()->json([
                'error' => 'Transaksi gagal, stok tidak cukup',
                'message' => $msg,
            ], 500);
        }
    }

    public function cancel($id)
    {
        $transaksi = Transaksi::with('details')->findOrFail($id);

        if ($transaksi->status !== 'lunas') {
            return response()->json(['error' => 'Transaksi belum lunas / sudah dibatalkan'], 400);
        }

        DB::transaction(function () use ($transaksi) {
            // Kembalikan stok
            foreach ($transaksi->details as $detail) {
                Produk::where('id', $detail->produk_id)
                    ->increment('stok', $detail->jumlah);
            }

            // Update status transaksi
            $transaksi->update(['status' => 'dibatalkan']);
        });

        return response()->json(['success' => 'Transaksi berhasil dibatalkan']);
    }



    public function invoice($id)
    {
        $transaksi = Transaksi::with(['details.produk', 'user'])->findOrFail($id);

        $html = view('kasir.transaksi.invoice', compact('transaksi'))->render();

        $mpdf = new Mpdf([
            'format' => 'A5', // bisa A4, A5, atau custom ['80', '200'] mm utk thermal
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output("invoice-{$transaksi->invoice}.pdf", 'I');
        // 'I' = inline (browser), 'D' = download, 'F' = simpan ke file
    }

    public function historyData(Request $request)
    {
        $query = Transaksi::with('user', 'pelanggan', 'details.produk')->latest();

        // filter opsional
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }
        if ($request->filled('kasir')) {
            $query->where('user_id', $request->kasir);
        }
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        // pagination (misal 10 per page)
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $transaksis = $query->paginate($perPage, ['*'], 'page', $page);

        // ubah ke JSON response standar
        return response()->json([
            'data' => $transaksis->items(),
            'pagination' => [
                'total' => $transaksis->total(),
                'per_page' => $transaksis->perPage(),
                'current_page' => $transaksis->currentPage(),
                'last_page' => $transaksis->lastPage(),
            ]
        ]);
    }



    public function historyDetail($id)
    {
        $transaksi = Transaksi::with(['user', 'pelanggan', 'details.produk'])->find($id);

        if (!$transaksi) {
            return response()->json([
                'error' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'id'        => $transaksi->id,
            'invoice'   => $transaksi->invoice,
            'tanggal'   => $transaksi->created_at->format('Y-m-d H:i:s'),
            'kasir'     => $transaksi->user?->name ?? '-',
            'pelanggan' => $transaksi->pelanggan?->nama ?? 'Umum',
            'total'     => $transaksi->total,
            'diskon'    => $transaksi->diskon,
            'bayar'     => $transaksi->bayar,
            'kembali'   => $transaksi->kembali,
            'metode'    => $transaksi->metode_pembayaran,
            'status'    => $transaksi->status,
            'items'     => $transaksi->details->map(function ($d) {
                return [
                    'produk'   => $d->produk?->nama ?? 'Produk hilang',
                    'kode'     => $d->produk?->kode_produk ?? '-',
                    'qty'      => $d->jumlah,
                    'harga'    => $d->harga_jual,
                    'subtotal' => $d->subtotal,
                ];
            }),
            'invoice_url' => route('kasir.transaksi.invoice', $transaksi->id),
        ]);
    }

    public function rekapHarian(Request $request)
    {
        $tanggal = $request->get('tanggal', Carbon::today()->toDateString());

        $query = Transaksi::whereDate('created_at', $tanggal);

        // total transaksi (jumlah record)
        $jumlahTransaksi = $query->count();

        // total omzet = SUM total - diskon
        $omzet = $query->sum(DB::raw('total - COALESCE(diskon,0)'));

        // total bayar (uang diterima kasir)
        $totalBayar = $query->sum('bayar');

        // total kembalian
        $totalKembali = $query->sum('kembali');

        // breakdown metode pembayaran
        $metode = $query->select('metode_pembayaran', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('metode_pembayaran')
            ->pluck('jumlah', 'metode_pembayaran');

        return response()->json([
            'tanggal'          => $tanggal,
            'jumlah_transaksi' => $jumlahTransaksi,
            'omzet'            => $omzet,
            'total_bayar'      => $totalBayar,
            'total_kembali'    => $totalKembali,
            'metode'           => $metode, // contoh: { "cash": 8, "qris": 3 }
        ]);
    }

    public function laporanHarian()
    {
        return view('kasir.laporan.laporan-harian');
    }

}
