<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailTransaksi>
 */
class DetailTransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $harga = $this->faker->randomElement(['10000', '12500', '15000', '20000']);
        $qty = rand(1, 5);
        $subtotal = intval($harga * $qty);
        return [
            'transaksi_id' => rand(1, 10),
            'paket_id' => rand(1, 5),
            'harga' => $harga,
            'qty' => $qty,
            'keterangan' => $this->faker->sentence(),
            'subtotal' => $subtotal
        ];
    }
}
