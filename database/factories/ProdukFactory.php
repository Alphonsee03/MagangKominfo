<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kategori;

class ProdukFactory extends Factory
{
    public function definition(): array
    {
        $hargaBeli = $this->faker->numberBetween(5000, 100000);
        $persentase = $this->faker->numberBetween(5, 15);
        $hargaJual = $hargaBeli + ($hargaBeli * $persentase / 100);

        return [
            'kategori_id' => Kategori::inRandomOrder()->first()->id ?? Kategori::factory(),
            'kode_produk' => strtoupper($this->faker->bothify('????####')), // contoh: ABCD1234
            'nama' => $this->faker->words(2, true), // contoh: "Beras Premium"
            'harga_beli' => $hargaBeli,
            'harga_jual' => $hargaJual,
            'stok' => $this->faker->numberBetween(10, 200),
            'deskripsi' => $this->faker->sentence(6, true),
            'foto' => null,
        ];
    }
}

