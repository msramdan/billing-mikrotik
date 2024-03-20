<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OltSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('olts')->insert([
            'company_id' => 1,
            'name' => 'OLTC320-SAWIT',
            'type' => 'zte',
            'host' => '103.162.205.97',
            'telnet_port' => 200,
            'telnet_username' => 'grnet',
            'telnet_password' => 'bismillah',
            'snmp_port' => '201',
            'ro_community' => 'onewanro',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
