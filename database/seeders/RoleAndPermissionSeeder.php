<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'food-list']);
        Permission::create(['name' => 'food-create']);
        Permission::create(['name' => 'food-edit']);
        Permission::create(['name' => 'food-delete']);

        Permission::create(['name' => 'order-create']);
        Permission::create(['name' => 'order-list-own']);
        Permission::create(['name' => 'order-list-all']);
        Permission::create(['name' => 'order-status-update']);


        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            'food-list',
            'food-create',
            'food-edit',
            'order-list-all',
            'order-status-update'
        ]);

        $courier = Role::create(['name' => 'courier']);
        $courier->givePermissionTo([
            'food-list',
            'order-list-all',
            'order-status-update'
        ]);

        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo([
            'food-list',
            'order-create',
            'order-list-own'
        ]);
        
    }
}
