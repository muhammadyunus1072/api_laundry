<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $total = $this->faker->randomElement(['20000', '22000', '35000', '38000', '45000', '52000', '55000']);
        $tunai = 100000;
        $kembalian = intval($tunai - $total);
        return [
            'kode_invoice' => $this->faker->unique()->bothify('cnc-???##???#?###???#'),
            'tgl' => $this->faker->date('Y-m-d'),
            'tgl_bayar' => $this->faker->dateTimeBetween('+01 days', '+14 days'),
            'total' => $total,
            'tunai' => $tunai,
            'kembalian' => $kembalian,
            'statusOrder_id' => rand(1, 4),
            'statusBayar' => $this->faker->randomElement(['dibayar', 'belum_dibayar']),
            'user_id' => rand(1, 5),
            'outlet_id' => rand(1, 7)


        ];
    }
}
