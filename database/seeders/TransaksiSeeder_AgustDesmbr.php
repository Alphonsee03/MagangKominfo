<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\User;
use Carbon\Carbon;

class TransaksiSeeder_AgustDesmbr extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $kasirs = User::where('role', 'kasir')->pluck('id'); // ambil semua kasir (id=2,3,4)
        $produks = Produk::all();

        $startDate = Carbon::create(2024, 8, 1);
        $endDate   = Carbon::create(2024, 12, 30);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $transaksiPerHari = rand(1, 3);

            for ($i = 1; $i <= $transaksiPerHari; $i++) {
                $invoice = sprintf("INV-%s-%04d", $date->format('Ymd'), $i);

                $detailCount = rand(1, 3);
                $total = 0;
                $validDetails = [];

                for ($j = 0; $j < $detailCount; $j++) {
                    $produk = $produks->random();
                    $jumlah = rand(1, 3);

                    if ($produk->stok < $jumlah) {
                        continue;
                    }

                    $subtotal = $produk->harga_jual * $jumlah;
                    $total += $subtotal;

                    $validDetails[] = [
                        'produk'  => $produk,
                        'jumlah'  => $jumlah,
                        'subtotal'=> $subtotal,
                    ];
                }

                if (empty($validDetails)) {
                    continue;
                }

                $diskon = $faker->randomElement([0, 0, 0, 1000, 2000, 5000, 8000, 10000]);

                // simulasi bayar & kembali
                if ($faker->boolean(30)) {
                    $bayar = $total - $diskon + $faker->randomElement([1000, 2000, 5000, 10000]);
                } else {
                    $bayar = $total - $diskon;
                }
                $kembali = $bayar - ($total - $diskon);

                // pilih kasir random
                $kasirId = $kasirs->random();

                $transaksiId = DB::table('transaksis')->insertGetId([
                    'invoice'           => $invoice,
                    'user_id'           => $kasirId,
                    'pelanggan_id'      => null,
                    'tanggal'           => $date->format('Y-m-d'),
                    'total'             => $total,
                    'diskon'            => $diskon,
                    'bayar'             => $bayar,
                    'kembali'           => $kembali,
                    'metode_pembayaran' => $faker->randomElement(['cash', 'qris']),
                    'status'            => 'lunas',
                    'created_at'        => $date->copy(),
                    'updated_at'        => $date->copy(),
                ]);

                foreach ($validDetails as $detail) {
                    DB::table('detail_transaksis')->insert([
                        'transaksi_id' => $transaksiId,
                        'produk_id'    => $detail['produk']->id,
                        'jumlah'       => $detail['jumlah'],
                        'harga_jual'   => $detail['produk']->harga_jual,
                        'subtotal'     => $detail['subtotal'],
                        'created_at'   => $date->copy(),
                        'updated_at'   => $date->copy(),
                    ]);

                    DB::table('stok_logs')->insert([
                        'produk_id'   => $detail['produk']->id,
                        'tipe'        => 'keluar',
                        'jumlah'      => $detail['jumlah'],
                        'keterangan'  => 'Penjualan ' . $detail['produk']->nama,
                        'transaksi_id'=> $transaksiId,
                        'user_id'     => $kasirId,
                        'created_at'  => $date->copy(),
                        'updated_at'  => $date->copy(),
                    ]);

                    if ($detail['produk']->stok >= $detail['jumlah']) {
                        $detail['produk']->decrement('stok', $detail['jumlah']);
                    }
                }
            }
        }
    }
}
