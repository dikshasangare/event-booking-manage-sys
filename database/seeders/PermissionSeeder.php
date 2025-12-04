<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PermissionRegistrar clears and reloads all permission caches.
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Event Permissions
            'event.create',
            'event.view',
            'event.update',
            'event.delete',
            'event.publish',
            'event.unpublish',

            // Ticket Permissions
            'ticket.create',
            'ticket.view',
            'ticket.update',
            'ticket.delete',
            'ticket.sell',
            'ticket.refund',

            // Booking Permissions
            'booking.create',
            'booking.view',
            'booking.update',
            'booking.cancel',

            // User Management Permissions
            'user.view',
            'user.create',
            'user.update',
            'user.delete',

            // Finance Permissions
            'finance.view',
            'finance.refund',
            'finance.report',

            // Settings Permissions
            'settings.general',
            'settings.payment',
            'settings.email',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
