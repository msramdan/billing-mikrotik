<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TripaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_tripays')->insert([
            'url' => 'https://tripay.co.id/api-sandbox/',
            'kode_merchant' => 'T25329',
            'api_key' => 'DEV-wdWWQLZNPbOLCrgCJYSOwdOxmPEbqMid6EaCcEfI',
            'private_key' => 'AjWFE-HVt43-rEyO2-SOTw5-07X6d',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
