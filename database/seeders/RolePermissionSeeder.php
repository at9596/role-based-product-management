<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view dashboard',
            'view products',
            'create products',
            'edit products',
            'delete products',
            'manage categories',
            'view users',
            'edit users',
            'assign roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $customer = Role::firstOrCreate(['name' => 'Customer']);

        $admin->givePermissionTo($permissions);
        
        $manager->givePermissionTo([
        'view dashboard',
        'view products',
        'create products',
        'edit products',
        'manage categories',
        ]);

        $customer->givePermissionTo([
            'view products',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
