<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OdpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('odps')->insert([
            'company_id' => 1,
            'kode_odc' => 1,
            'nomor_port_odc' => 1,
            'kode_odp' => 'ODP-001',
            'wilayah_odp' => 1,
            'warna_tube_fo' => 'Merah',
            'nomor_tiang' => 1,
            'jumlah_port' => 16,
            'document' => '-',
            'description' => '-',
            'latitude' => '-8.2043641',
            'longitude' => '115.1346737',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
