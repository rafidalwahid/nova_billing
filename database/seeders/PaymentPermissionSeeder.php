<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // New payment management permissions
        $newPermissions = [
            'View Payment Records' => 'Access payment history, transaction details, and payment status information',
            'Process Customer Payments' => 'Handle payment processing, record payments, and update payment status',
            'Issue Payment Refunds' => 'Process refunds, chargebacks, and payment reversals for customer accounts',
            'Manage Payment Methods' => 'Configure payment gateways, enable/disable payment options, and update settings',
            'View Transaction History' => 'Access detailed transaction logs, gateway responses, and payment audit trails',
            'Void Payment Transactions' => 'Cancel pending payments and void completed transactions when authorized',
            'Generate Payment Reports' => 'Create financial reports, revenue analytics, and payment performance metrics',
        ];

        foreach ($newPermissions as $permissionName => $permissionDescription) {
            // Check if permission already exists
            $existingPermission = Permission::where('slug', Str::slug($permissionName))->first();

            if (!$existingPermission) {
                Permission::create([
                    'name' => $permissionName,
                    'slug' => Str::slug($permissionName),
                    'description' => $permissionDescription,
                    'module' => 'Payment Management',
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
     * Update role permissions to include new payment permissions
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

        // Billing Manager gets comprehensive billing and payment permissions
        if ($billingManager) {
            $billingManagerPermissions = Permission::whereIn('module', [
                'System Dashboard',
                'Customer Management',
                'Order Processing',
                'Invoice Management',
                'Payment Management',
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

        // Customer Support Representative gets limited payment permissions
        if ($supportRep) {
            $supportPermissions = Permission::whereIn('module', [
                'System Dashboard',
                'Customer Management',
                'Order Processing',
                'Invoice Management',
                'Payment Management',
                'Support Ticket System',
            ])->whereNotIn('slug', [
                'delete-invoice-records',
                'remove-customer-accounts',
                'cancel-customer-orders',
                'issue-payment-refunds',
                'void-payment-transactions',
                'manage-payment-methods',
            ])->get();
            $supportRep->permissions()->sync($supportPermissions->pluck('id')->toArray());
            $this->command->info("Updated Customer Support Representative permissions");
        }

        // Financial Controller gets financial and payment permissions
        if ($financialController) {
            $financialPermissions = Permission::whereIn('module', [
                'System Dashboard',
                'Customer Management',
                'Invoice Management',
                'Payment Management',
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
