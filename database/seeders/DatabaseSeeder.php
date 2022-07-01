<?php

namespace Database\Seeders;

use App\Models\DetailTransaksi;
use App\Models\Outlet;
use App\Models\Paket;
use App\Models\Role;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(3)->create();
        $this->call(StatusOrderSeeder::class);
        // $this->call(OutletSeeder::class);
        // Outlet::factory(7)->create();
        // Paket::factory(5)->create();
        // Transaksi::factory(20)->create();
        // DetailTransaksi::factory(42)->create();
        DB::table('roles')->insert([
            'role' => 'admin'
        ]);
        DB::table('roles')->insert([
            'role' => 'kasir'
        ]);
        DB::table('roles')->insert([
            'role' => 'pelanggan'
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
