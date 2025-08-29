<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->unique()->randomElement([
                'Minuman', 'Makanan', 'Snack Ringan',
                'Snack Berat', 'Obat', 'Bahan Kue'
            ]),
        ];
    }
}
