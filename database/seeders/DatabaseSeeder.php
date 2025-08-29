<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Produk;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 6 kategori tetap
        $kategoriList = [
            'Minuman', 'Makanan', 'Snack Ringan',
            'Snack Berat', 'Obat', 'Bahan Kue'
        ];
        $kategoriMap = [];
        foreach ($kategoriList as $kat) {
            $kategoriMap[$kat] = Kategori::firstOrCreate(['nama' => $kat]);
        }

        // 5 supplier
        $suppliers = Supplier::factory(5)->create();

        // Produk list sesuai kategori
        $produkKategori = [
            'Minuman' => [
                'Aqua 600ml', 'Teh Botol Sosro 350ml', 'Coca Cola 1,5L',
                'Fanta Strawberry 1,5L', 'Pocari Sweat 500ml',
                'Milo Kotak 200ml', 'Good Day Cappuccino 250ml'
            ],
            'Makanan' => [
                'Beras Ramos 5kg', 'Minyak Goreng Bimoli 1L', 'Gula Pasir Gulaku 1kg',
                'Telur Ayam 1kg', 'Indomie Goreng Original', 'Kecap ABC 600ml',
                'Tepung Terigu Segitiga Biru 1kg'
            ],
            'Snack Ringan' => [
                'Chitato Sapi Panggang 68g', 'Lays Rumput Laut 55g', 'Qtela Singkong 60g',
                'Taro Net 60g', 'Potabee BBQ 55g', 'Beng-Beng Wafer 20g', 'SilverQueen Chunky 65g'
            ],
            'Snack Berat' => [
                'Sosis Kanzler Beef 500g', 'Nugget So Good Ayam 500g', 'Bakso Sapi 1kg',
                'Kentang Beku McCain 1kg', 'Dimsum Ayam 500g'
            ],
            'Obat' => [
                'Paracetamol 500mg', 'Vitamin C 1000mg', 'Promag Tablet',
                'Bodrex Migra', 'Betadine Antiseptic 60ml'
            ],
            'Bahan Kue' => [
                'Coklat Bubuk Van Houten 100g', 'Ragi Fermipan 11g', 'Susu Kental Manis Indomilk 370g',
                'Keju Cheddar Kraft 175g', 'Butter Wisman 200g', 'Pewarna Makanan Merah Rose Brand 30ml'
            ]
        ];

        // Generate 50 produk
        foreach (range(1, 50) as $i) {
            $kategori = collect($kategoriList)->random();
            $kategoriId = $kategoriMap[$kategori]->id;

            // Ambil produk random sesuai kategori
            $namaProduk = collect($produkKategori[$kategori])->random();

            // Harga beli realistis (5k - 100k)
            $hargaBeli = fake()->numberBetween(5000, 100000);
            $persentase = fake()->numberBetween(5, 15);
            $hargaJual = $hargaBeli + ($hargaBeli * $persentase / 100);

            $produk = Produk::create([
                'kategori_id' => $kategoriId,
                'kode_produk' => strtoupper(fake()->bothify('????####')),
                'nama' => $namaProduk,
                'harga_beli' => $hargaBeli,
                'harga_jual' => $hargaJual,
                'stok' => fake()->numberBetween(10, 200),
                'deskripsi' => $namaProduk . " kualitas terbaik dan banyak dicari.",
                'foto' => null,
            ]);

            // Attach ke supplier (1-2 random)
            $produk->suppliers()->attach(
                $suppliers->random(rand(1, 2))->pluck('id')->toArray()
            );
        }
    }
}


