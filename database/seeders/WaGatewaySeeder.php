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
            'api_key' => '3e655e6433d5b73e7ce91fbcd0e07974d9e288c0',
            'is_active' => 'No',
        ]);
    }
}
