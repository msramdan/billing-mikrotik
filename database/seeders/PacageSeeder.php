<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PacageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('packages')->insert([
            'company_id' => 1,
            'nama_layanan' => 'Gofiber5Mbps',
            'harga' => 165000,
            'kategori_paket_id' => 1,
            'profile' => 'test',
            'keterangan' => '-',
            'is_active' => 'Yes',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
