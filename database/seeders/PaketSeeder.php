<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket 50.000',
            'jumlah_router' => 1,
            'jumlah_pelanggan' => 100,
            'jumlah_olt' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket 100.000',
            'jumlah_router' => 2,
            'jumlah_pelanggan' => 250,
            'jumlah_olt' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket 150.000',
            'jumlah_router' => 4,
            'jumlah_pelanggan' => 500,
            'jumlah_olt' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket 300.000',
            'jumlah_router' => 5,
            'jumlah_pelanggan' => 1000,
            'jumlah_olt' => 3,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket Platinum',
            'jumlah_router' => 10,
            'jumlah_pelanggan' => 2000,
            'jumlah_olt' => 4,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
