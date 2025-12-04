<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('Password1!'),
                'contact_number' => '9898989898'
            ]
        );
        $admin->assignRole('Admin');

        // Event Manager
        $manager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Event Manager',
                'password' => Hash::make('Password1!'),
                'contact_number' => '9898989898'
            ]
        );
        $manager->assignRole('Event Manager');

        // Organizer
        $organizer = User::firstOrCreate(
            ['email' => 'organizer@example.com'],
            [
                'name' => 'Organizer User',
                'password' => Hash::make('Password1!'),
                'contact_number' => '9898989898'
            ]
        );
        $organizer->assignRole('Organizer');

        // Customer Support
        $support = User::firstOrCreate(
            ['email' => 'support@example.com'],
            [
                'name' => 'Support Staff',
                'password' => Hash::make('Password1!'),
                'contact_number' => '9898989898'
            ]
        );
        $support->assignRole('Customer Support');

        // Staff
        $staff = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Event Staff',
                'password' => Hash::make('Password1!'),
                'contact_number' => '9898989898'
            ]
        );
        $staff->assignRole('Staff');

        // Customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Customer User',
                'password' => Hash::make('Password1!'),
                'contact_number' => '9898989898'
            ]
        );
        $customer->assignRole('Customer');
    }
}
