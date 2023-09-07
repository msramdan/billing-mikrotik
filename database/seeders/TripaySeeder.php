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
            'url' => 'https://tripay.co.id/api/',
            'kode_merchant' => 'T13939',
            'api_key' => 'DEV-bSvGlvc4N0uyV5Jd3jLQmO2G1rrjTVPxvndpkuk0',
            'private_key' => 'kH1zF-vXeLC-xJIRu-R5koW-x4aIi',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
