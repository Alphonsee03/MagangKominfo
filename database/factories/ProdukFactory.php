<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    public function definition(): array
    {
        $namaProduk = $this->faker->randomElement([
            'Beras Ramos 5kg',
            'Minyak Goreng Bimoli 1L',
            'Mie Instan Indomie Goreng',
            'Mie Instan Indomie Ayam Bawang',
            'Gula Pasir Gulaku 1kg',
            'Susu Bubuk Dancow 400g',
            'Kopi Kapal Api Special 165g',
            'Teh Celup Sariwangi 25pcs',
            'Susu UHT Frisian Flag 225ml',
            'Air Mineral Aqua 600ml',
            'Rokok Djarum Super 12',
            'Rokok Gudang Garam Surya 12',
            'Coklat Bubuk Van Houten 100g',
            'Kecap Manis ABC 135ml',
            'Saus Sambal Indofood 135ml',
            'Sarden ABC 155g',
            'Biskuit Roma Kelapa 300g',
            'Snack Chitato Sapi Panggang 68g',
            'Tepung Terigu Segitiga Biru 1kg',
            'Sabun Mandi Lifebuoy 75g',
            'Shampo Sunsilk 170ml',
            'Detergen Rinso 800g',
            'Pewangi Molto 900ml',
            'Obat Paracetamol 500mg',
            'Obat Tolak Angin Cair 15ml',
            'Susu Bayi SGM 400g',
            'Popok Bayi Sweety Gold S40',
            'Tepung Beras Rose Brand 500g',
            'Biskuit Oreo 137g',
            'Permen Kopiko 150g',
            'Minuman Isotonik Pocari Sweat 500ml',
            'Minuman Teh Pucuk Harum 500ml',
            'Minuman Sprite 390ml',
            'Minuman Fanta 390ml',
            'Minuman Coca Cola 390ml',
            'Air Mineral Le Minerale 600ml',
            'Rokok Marlboro Merah 20',
            'Rokok Sampoerna Mild 16',
            'Rokok LA Bold 16',
            'Kopi Good Day Cappuccino 250ml',
            'Kopi Luwak White Coffee 10s',
            'Susu Ultra Milk Coklat 200ml',
            'Susu Ultra Milk Strawberry 200ml',
            'Kecap Manis Bango 135ml',
            'Saus Tomat Del Monte 135ml',
            'Margarin Blue Band 200g',
            'Mentega Wisman 200g',
            'Keju Kraft Cheddar 175g',
            'Sosis So Nice 10s',
            'Nugget Fiesta Chicken 500g',
            'Nugget So Good 500g',
            'Ayam Goreng Tepung Siap Masak 1kg',
            'Telur Ayam Negeri 1kg',
            'Ikan Asin Peda 250g',
            'Kerupuk Udang 250g',
            'Bumbu Masako Ayam 100g',
            'Bumbu Royco Sapi 100g',
            'Cabe Bubuk 50g',
            'Lada Putih Bubuk 50g',
            'Obat Minyak Kayu Putih 60ml',
            'Obat Freshcare 10ml',
            'Vitamin C Youvit 7s',
            'Vitamin Enervon C 30s',
            'Sampoerna Kretek 12',
            'Djarum Black Cappuccino 12',
            'SilverQueen Coklat 65g',
            'Tango Wafer Coklat 130g',
            'Qtela Singkong Original 185g',
            'Piattos Snack 75g',
            'Malkist Crackers Roma 135g',
        ]);

        $kategori_id = 1; // default makanan

        if (preg_match('/rokok|Djarum|Sampoerna|Surya|Kretek/i', $namaProduk)) {
            $kategori_id = 9; // Rokok
        } elseif (preg_match('/kopi|teh|minuman|susu|aqua|coca cola|fanta|sprite|le minerale/i', $namaProduk)) {
            $kategori_id = 2; // Minuman
        } elseif (preg_match('/sabun|shampo|detergen|popok|pewangi|bayi/i', $namaProduk)) {
            $kategori_id = 8; // Kebutuhan Rumah Tangga
        } elseif (preg_match('/obat|vitamin/i', $namaProduk)) {
            $kategori_id = 6; // Kesehatan
        } elseif (preg_match('/snack|chitato|biskuit|permen|Coklat/i', $namaProduk)) {
            $kategori_id = 4; // Snack
        } elseif (preg_match('/Sarden|Nugget|/i', $namaProduk)) {
            $kategori_id = 5; // Makanan
        }

        // harga beli dan jual bulat
        $hargaBeli = $this->faker->numberBetween(4000, 70000);
        $hargaJual = $hargaBeli + $this->faker->numberBetween(2500, 10000);

        return [
            'kategori_id' => $this->faker->numberBetween(1, 9),
            'kode_produk' => $this->faker->unique()->numerify(str_repeat('#', 13)),
            'nama' => $namaProduk,
            'harga_beli' => $hargaBeli,
            'harga_jual' => $hargaJual,
            'stok' => $this->faker->numberBetween(300, 450),
            'deskripsi' => $namaProduk . ' kualitas terbaik.',
            'foto' => null,
            'created_at' => $this->faker->dateTimeBetween('2024-02-01', '2025-09-07'),
            'updated_at' => $this->faker->dateTimeBetween('2024-02-01', '2025-09-07'),
        ];
    }
}
