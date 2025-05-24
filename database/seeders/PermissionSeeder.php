<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'Dashboard' => [
                'View Dashboard',
            ],
            'Customers' => [
                'View Customers',
                'Create Customers',
                'Edit Customers',
                'Delete Customers',
                'Suspend Customers',
                'Activate Customers',
            ],
            'Orders' => [
                'View Orders',
                'Create Orders',
                'Process Orders',
                'Cancel Orders',
            ],
            'Invoices' => [
                'View Invoices',
                'Create Invoices',
                'Edit Invoices',
                'Delete Invoices',
                'Mark as Paid',
                'Process Refunds',
            ],
            'Products' => [
                'View Products',
                'Create Products',
                'Edit Products',
                'Delete Products',
            ],
            'Servers' => [
                'View Servers',
                'Create Servers',
                'Edit Servers',
                'Delete Servers',
                'Test Connection',
            ],
            'Tickets' => [
                'View Tickets',
                'Respond to Tickets',
                'Close Tickets',
                'Delete Tickets',
            ],
            'Staff' => [
                'View Staff',
                'Create Staff',
                'Edit Staff',
                'Delete Staff',
            ],
            'Roles' => [
                'View Roles',
                'Create Roles',
                'Edit Roles',
                'Delete Roles',
            ],
        ];

        foreach ($modules as $module => $permissions) {
            foreach ($permissions as $permission) {
                Permission::create([
                    'name' => $permission,
                    'slug' => Str::slug($permission),
                    'description' => $permission,
                    'module' => $module,
                ]);
            }
        }
    }
}
