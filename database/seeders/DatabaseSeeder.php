<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(RoleAndPermissionSeeder::class);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
        ]);
        $admin->assignRole('admin');

        $manager = User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@gmail.com',
        ]);
        $manager->assignRole('manager');

        $courier = User::factory()->create([
            'name' => 'Courier User',
            'email' => 'courier@gmail.com',
        ]);
        $courier->assignRole('courier');

        $user = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@gmail.com',
        ]);
        $user->assignRole('user');
    } 
}
