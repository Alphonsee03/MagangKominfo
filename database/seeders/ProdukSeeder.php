<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\Supplier;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProdukSeeder extends Seeder
{

    public function run(): void
    {

        $suppliers = Supplier::all();

        Produk::factory()->count(70)->create()->each(function ($produk) use ($suppliers) {
            // stok_logs (barang masuk)
            DB::table('stok_logs')->insert([
                'produk_id'   => $produk->id,
                'tipe'        => 'masuk',
                'jumlah'      => $produk->stok,
                'keterangan'  => 'Stok awal produk' . $produk->nama,
                'transaksi_id' => null,
                'user_id'     => 1,
                'created_at'  => $produk->created_at,
                'updated_at'  => $produk->updated_at,
            ]);

            // produk_supplier (hubungkan produk ke 2-3 supplier random)
            $randomSuppliers = $suppliers->random(rand(1, 2));
            foreach ($randomSuppliers as $supplier) {
                DB::table('produk_supplier')->insert([
                    'produk_id'  => $produk->id,
                    'supplier_id' => $supplier->id,
                    'created_at' => $produk->created_at,
                    'updated_at' => $produk->updated_at,
                ]);
            }
        });
    }
}
