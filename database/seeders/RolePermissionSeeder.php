<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::pluck('name')->toArray();

        // -------------------------
        // Admin  → All permissions
        // -------------------------
        $admin = Role::where('name', 'Admin')->first();
        $admin->syncPermissions($permissions);

        // -------------------------
        // Event Manager
        // -------------------------
        $eventManagerPermissions = [
            'event.create',
            'event.view',
            'event.update',
            'event.delete',
            'event.publish',
            'event.unpublish',

            'ticket.create',
            'ticket.view',
            'ticket.update',
            'ticket.delete',

            'booking.view',

            'finance.report',
        ];

        Role::where('name', 'Event Manager')->first()->syncPermissions($eventManagerPermissions);

        // -------------------------
        // Organizer
        // -------------------------
        $organizerPermissions = [
            'event.create',
            'event.view',
            'event.update',
            'ticket.create',
            'ticket.view',
            'ticket.update',

            'booking.view',
            'finance.view',
        ];

        Role::where('name', 'Organizer')->first()->syncPermissions($organizerPermissions);

        // -------------------------
        // Customer Support
        // -------------------------
        $supportPermissions = [
            'event.view',
            'ticket.view',
            'ticket.refund',
            'booking.view',
            'booking.update',
            'booking.cancel',
            'finance.refund',
            'finance.view',
        ];

        Role::where('name', 'Customer Support')->first()->syncPermissions($supportPermissions);

        // -------------------------
        // Staff (NEW)
        // -------------------------
        $staffPermissions = [
            'ticket.view',
            'booking.view',
            'booking.update', // mark attendance
        ];

        Role::where('name', 'Staff')->first()->syncPermissions($staffPermissions);

        // -------------------------
        // Customer
        // -------------------------
        $customerPermissions = [
            'event.view',
            'ticket.view',
            'booking.create',
            'booking.view',
            'booking.cancel',
        ];

        Role::where('name', 'Customer')->first()->syncPermissions($customerPermissions);
    }
}
