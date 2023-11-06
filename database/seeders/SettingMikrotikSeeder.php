<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingMikrotikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settingmikrotiks')->insert([
            'company_id' => 1,
            'identitas_router' => 'CCR1016-12G',
            'host' => '103.122.65.234',
            'port' => 83,
            'username' => 'sawitskylink',
            'password' => 'sawit064199',
            'is_active' => 'Yes',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('settingmikrotiks')->insert([
            'company_id' => 1,
            'identitas_router' => 'Router Test',
            'host' => '103.122.65.234:86',
            'port' => 8728,
            'username' => 'sawitskylink',
            'password' => 'sawit064199',
            'is_active' => 'No',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
