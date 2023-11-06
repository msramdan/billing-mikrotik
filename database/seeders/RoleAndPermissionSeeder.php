<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role, Permission};

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdmin = Role::create(['name' => 'Super Admin']);
        $clientCompany = Role::create(['name' => 'Client Company']);

        foreach (config('permission.permissions') as $permission) {
            foreach ($permission['access'] as $access) {
                Permission::create(['name' => $access]);
            }
        }
        $userAdmin = User::first();
        $userAdmin->assignRole('Super Admin');
        $superAdmin->givePermissionTo(Permission::all());


        $excludedIds = [
            'user view',
            'user create',
            'user edit',
            'user delete',
            'role & permission view',
            'role & permission create',
            'role & permission edit',
            'role & permission delete',
            'company view',
            'company create',
            'company edit',
            'company delete',
            'paket view',
            'paket create',
            'paket edit',
            'paket delete'
        ];
        $userClient = User::find(2);
        $userClient->assignRole('Client Company');
        $clientCompany->givePermissionTo(Permission::whereNotIn('name', $excludedIds)->get());
    }
}
