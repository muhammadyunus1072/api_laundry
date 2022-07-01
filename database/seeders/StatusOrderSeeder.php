<?php

namespace Database\Seeders;

use App\Models\StatusOrder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Statuses = [
            [
                'status' => 'baru'
            ],
            [
                'status' => 'proses'
            ],
            [
                'status' => 'selesai'
            ],
            [
                'status' => 'diambil'
            ]
            ];

            foreach($Statuses as $status){
                StatusOrder::create($status);
            }
    }
}
