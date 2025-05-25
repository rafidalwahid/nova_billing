<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubscriptionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // New subscription management permissions
        $newPermissions = [
            'View Subscription Records' => 'Browse customer subscriptions, billing cycles, and subscription status information',
            'Create Customer Subscriptions' => 'Set up new recurring billing subscriptions for products and services',
            'Modify Subscription Details' => 'Update subscription billing cycles, amounts, and configuration settings',
            'Cancel Customer Subscriptions' => 'Terminate subscriptions and handle cancellation workflows with proper notifications',
            'Suspend Subscription Services' => 'Temporarily suspend subscriptions for non-payment or policy violations',
            'Resume Suspended Subscriptions' => 'Reactivate suspended subscriptions and restore service access',
            'Process Subscription Upgrades' => 'Handle subscription plan changes, upgrades, and service modifications',
            'Manage Subscription Items' => 'Add, modify, or remove individual items within subscription packages',
            'Generate Recurring Invoices' => 'Create automated recurring invoices based on subscription billing cycles',
            'View Subscription Analytics' => 'Access subscription metrics, revenue reports, and billing performance data',
        ];

        foreach ($newPermissions as $permissionName => $permissionDescription) {
            // Check if permission already exists
            $existingPermission = Permission::where('slug', Str::slug($permissionName))->first();

            if (!$existingPermission) {
                Permission::create([
                    'name' => $permissionName,
                    'slug' => Str::slug($permissionName),
                    'description' => $permissionDescription,
                    'module' => 'Subscription Management',
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
     * Update role permissions to include new subscription permissions
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

        // Billing Manager gets comprehensive billing and subscription permissions
        if ($billingManager) {
            $billingManagerPermissions = Permission::whereIn('module', [
                'System Dashboard',
                'Customer Management',
                'Order Processing',
                'Invoice Management',
                'Payment Management',
                'Subscription Management',
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

        // Customer Support Representative gets limited subscription permissions
        if ($supportRep) {
            $supportPermissions = Permission::whereIn('module', [
                'System Dashboard',
                'Customer Management',
                'Order Processing',
                'Invoice Management',
                'Payment Management',
                'Subscription Management',
                'Support Ticket System',
            ])->whereNotIn('slug', [
                'delete-invoice-records',
                'remove-customer-accounts',
                'cancel-customer-orders',
                'issue-payment-refunds',
                'void-payment-transactions',
                'manage-payment-methods',
                'cancel-customer-subscriptions',
                'modify-subscription-details',
                'process-subscription-upgrades',
            ])->get();
            $supportRep->permissions()->sync($supportPermissions->pluck('id')->toArray());
            $this->command->info("Updated Customer Support Representative permissions");
        }

        // Financial Controller gets financial and subscription analytics permissions
        if ($financialController) {
            $financialPermissions = Permission::whereIn('module', [
                'System Dashboard',
                'Customer Management',
                'Invoice Management',
                'Payment Management',
                'Subscription Management',
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
