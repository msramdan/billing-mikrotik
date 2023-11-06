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
        $this->call(UserSeeder::class);
        $this->call(RoleAndPermissionSeeder::class);
        // $this->call(PaketLanggananSeeder::class);
        // $this->call(CompanySeeder::class);
        // $this->call(WaGatewaySeeder::class);
        // $this->call(PrivacyPolicySeeder::class);
        $this->call(RouterMikrotikSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(PacageKategoriSeeder::class);
        $this->call(PacageSeeder::class);
        $this->call(OdcSeeder::class);
        $this->call(OdpSeeder::class);
        // $this->call(TripaySeeder::class);

    }
}
