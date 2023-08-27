<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouterMikrotikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settingmikrotiks')->insert([
            'identitas_router' => 'CCR1016-12G',
            'host' => '103.122.65.234',
            'port' => 83,
            'username' => 'sawitskylink',
            'password' => 'sawit064199',
            'is_active' => 'Yes',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
