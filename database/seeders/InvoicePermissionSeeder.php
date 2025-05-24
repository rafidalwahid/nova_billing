<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InvoicePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // New invoice management permissions
        $newPermissions = [
            'Send Invoice Emails' => 'Email invoices to customers with customizable subject and message content',
            'Mark Invoices as Paid' => 'Quick action to mark invoices as paid and update payment status',
            'Generate Invoices from Orders' => 'Automatically create invoices from completed customer orders',
            'Manage Invoice Line Items' => 'Create, edit, and delete individual line items within invoices',
            'View Invoice Line Items' => 'Access detailed breakdown of invoice line items and billing components',
        ];

        foreach ($newPermissions as $permissionName => $permissionDescription) {
            // Check if permission already exists
            $existingPermission = Permission::where('slug', Str::slug($permissionName))->first();

            if (!$existingPermission) {
                Permission::create([
                    'name' => $permissionName,
                    'slug' => Str::slug($permissionName),
                    'description' => $permissionDescription,
                    'module' => 'Invoice Management',
                ]);

                $this->command->info("Created permission: {$permissionName}");
            } else {
                $this->command->warn("Permission already exists: {$permissionName}");
            }
        }

        // Update role permissions
        $this->updateRolePermissions();
    }

    /**
     * Update role permissions to include new invoice permissions
     */
    private function updateRolePermissions(): void
    {
        $systemAdmin = Role::where('name', 'System Administrator')->first();
        $billingManager = Role::where('name', 'Billing Manager')->first();
        $supportRep = Role::where('name', 'Customer Support Representative')->first();
        $financialController = Role::where('name', 'Financial Controller')->first();

        // Get all permissions
        $allPermissions = Permission::all();

        // System Administrator gets ALL permissions
        if ($systemAdmin) {
            $systemAdmin->permissions()->sync($allPermissions->pluck('id')->toArray());
            $this->command->info("Updated System Administrator permissions");
        }

        // Billing Manager gets comprehensive billing and management permissions
        if ($billingManager) {
            $billingManagerPermissions = Permission::whereIn('module', [
                'System Dashboard',
                'Customer Management',
                'Order Processing',
                'Invoice Management',
                'Product Catalog',
                'Support Ticket System',
                'Staff Administration',
            ])->whereNotIn('slug', [
                'remove-staff-access',
                'delete-system-roles',
                'remove-server-resources',
            ])->get();
            $billingManager->permissions()->sync($billingManagerPermissions->pluck('id')->toArray());
            $this->command->info("Updated Billing Manager permissions");
        }

        // Customer Support Representative gets limited invoice permissions
        if ($supportRep) {
            $supportPermissions = Permission::whereIn('module', [
                'System Dashboard',
                'Customer Management',
                'Support Ticket System',
            ])->orWhereIn('slug', [
                'view-customer-orders',
                'view-invoice-records',
                'view-invoice-line-items',
                'view-product-listings',
            ])->get();
            $supportRep->permissions()->sync($supportPermissions->pluck('id')->toArray());
            $this->command->info("Updated Customer Support Representative permissions");
        }

        // Financial Controller gets financial and reporting permissions
        if ($financialController) {
            $financialPermissions = Permission::whereIn('module', [
                'System Dashboard',
                'Customer Management',
                'Invoice Management',
                'Order Processing',
            ])->orWhereIn('slug', [
                'view-product-listings',
                'view-support-tickets',
            ])->get();
            $financialController->permissions()->sync($financialPermissions->pluck('id')->toArray());
            $this->command->info("Updated Financial Controller permissions");
        }
    }
}
