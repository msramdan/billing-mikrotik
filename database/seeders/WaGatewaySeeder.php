<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WaGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('wa_gateways')->insert([
            'url' => 'https://wagw.sitarsius.com/api/',
            'api_key' => '2faa16d94efa15236186b0a69bbee00b080b6886',
            'is_active' => 'Yes',
            'footer_pesan_wa_tagihan' => 'Admin',
            'footer_pesan_wa_pembayaran' => 'Admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
