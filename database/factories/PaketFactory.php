<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paket>
 */
class PaketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'jenis' => $this->faker->randomElement(['selimut', 'kiloan', 'bed cover', 'lainnya']),
            'nama_paket' => $this->faker->word(),
            'harga' => $this->faker->randomElement(['10000', '12500', '15000', '20000'])
        ];
    }
}
