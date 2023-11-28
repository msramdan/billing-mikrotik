<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PaketSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(SettingMikrotikSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(PacageKategoriSeeder::class);
        $this->call(PacageSeeder::class);
        $this->call(OdcSeeder::class);
        $this->call(OdpSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(OltSeeder::class);
    }
}
