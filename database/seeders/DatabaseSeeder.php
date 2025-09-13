<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Produk;
use App\Models\Transaksi;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TransaksiSeeder::class);
        $this->call(TransaksiSeeder::class);
        $this->call(ProdukSeeder::class);
    }
}


