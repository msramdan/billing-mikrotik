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
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('settingmikrotiks')->insert([
            'company_id' => 1,
            'identitas_router' => 'Company 1B',
            'host' => '103.122.65.234',
            'port' => 83,
            'username' => 'sawitskylink',
            'password' => 'sawit064199',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // DB::table('settingmikrotiks')->insert([
        //     'company_id' => 2,
        //     'identitas_router' => 'Company 2A',
        //     'host' => '103.122.65.234',
        //     'port' => 83,
        //     'username' => 'sawitskylink',
        //     'password' => 'sawit064199',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // ]);

        // DB::table('settingmikrotiks')->insert([
        //     'company_id' => 2,
        //     'identitas_router' => 'Company 2B',
        //     'host' => '103.122.65.234',
        //     'port' => 83,
        //     'username' => 'sawitskylink',
        //     'password' => 'sawit064199',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // ]);
    }
}
