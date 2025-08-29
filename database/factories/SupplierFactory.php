<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->company(),
            'telepon' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->streetAddress() . ', ' . $this->faker->city(),
        ];
    }
}

