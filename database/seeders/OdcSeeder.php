<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OdcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('odcs')->insert([
            'kode_odc' => 'ODC-001',
            'wilayah_odc' => 1,
            'nomor_port_olt' => 1,
            'warna_tube_fo' => 'Merah',
            'nomor_tiang' => 1,
            'document' => '-',
            'description' => '-',
            'latitude' => '-8.2043641',
            'longitude' => '115.1346737',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
