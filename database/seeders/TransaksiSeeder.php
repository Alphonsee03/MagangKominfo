<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\User;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $kasir = User::where('role', 'kasir')->first();
        $produks = Produk::all();

        $startDate = Carbon::create(2024, 2, 1);
        $endDate   = Carbon::create(2025, 8, 30);

        // loop per hari
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $transaksiPerHari = rand(2, 6);

            for ($i = 1; $i <= $transaksiPerHari; $i++) {
                $invoice = sprintf("INV-%s-%04d", $date->format('Ymd'), $i);

                $detailCount = rand(1, 5);
                $total = 0;
                $validDetails = [];

                // pilih produk untuk detail
                for ($j = 0; $j < $detailCount; $j++) {
                    $produk = $produks->random();
                    $jumlah = rand(1, 5);

                    // skip kalau stok tidak cukup
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

                // skip transaksi kalau semua detail tidak valid
                if (empty($validDetails)) {
                    continue;
                }

                // diskon hanya sebagian transaksi
                $diskon = $faker->randomElement([0, 0, 0, 1000, 2000, 5000]);
                $bayar = $total - $diskon;
                $kembali = 0;

                // insert transaksi
                $transaksiId = DB::table('transaksis')->insertGetId([
                    'invoice'           => $invoice,
                    'user_id'           => $kasir->id,
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

                // insert detail + stok_logs
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
                        'user_id'     => $kasir->id,
                        'created_at'  => $date->copy(),
                        'updated_at'  => $date->copy(),
                    ]);

                    // kurangi stok produk
                    $detail['produk']->decrement('stok', $detail['jumlah']);
                }
            }
        }
    }
}
