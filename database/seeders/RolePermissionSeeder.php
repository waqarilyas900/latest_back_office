<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'add location',
            'attach location',
            'add user',
            'manage permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $normalUser = Role::firstOrCreate(['name' => 'Normal User']);

        // Assign all permissions to Super Admin
        $superAdmin->syncPermissions([
            'add location',
            'attach location',
            'add user',
            'manage permissions',
        ]);

        // Normal User has no permissions by default
        $normalUser->syncPermissions([]);
    }
}

