<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketLanggananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket Unlimited',
            'jumlah_router' => 0,
            'jumlah_pelanggan' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket 50.000',
            'jumlah_router' => 1,
            'jumlah_pelanggan' => 100,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket 100.000',
            'jumlah_router' => 2,
            'jumlah_pelanggan' => 250,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket 150.000',
            'jumlah_router' => 4,
            'jumlah_pelanggan' => 500,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket 300.000',
            'jumlah_router' => 5,
            'jumlah_pelanggan' => 1000,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket Platinum',
            'jumlah_router' => 10,
            'jumlah_pelanggan' => 2000,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
