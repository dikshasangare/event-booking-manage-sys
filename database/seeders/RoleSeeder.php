<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Event Manager', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Organizer', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Customer Support', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Staff', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Customer', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ];

        Role::insert($roles);
    }
}
