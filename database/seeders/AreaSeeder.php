<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('area_coverages')->insert([
            'kode_area' => 'AC001',
            'tampilkan_register' => 'Yes',
            'nama' => 'Ambengan',
            'alamat' => 'desa ambengan, Rt/Rw 001/001, Ambengan, Kec. Sukasada, Kab. Buleleng, Prov. Bali - Indonesia 81161',
            'keterangan' => '-',
            'radius' => 100,
            'latitude' => '-8.2043641',
            'longitude' => '115.1346737',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
