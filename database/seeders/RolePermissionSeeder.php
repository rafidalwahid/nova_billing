<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all roles with updated names
        $systemAdmin = Role::where('name', 'System Administrator')->first();
        $billingManager = Role::where('name', 'Billing Manager')->first();
        $supportRep = Role::where('name', 'Customer Support Representative')->first();
        $financialController = Role::where('name', 'Financial Controller')->first();
        $salesRep = Role::where('name', 'Sales Representative')->first();

        // Get all permissions
        $allPermissions = Permission::all();

        // System Administrator gets ALL permissions
        if ($systemAdmin) {
            $systemAdmin->permissions()->sync($allPermissions->pluck('id')->toArray());
            echo "Assigned " . $allPermissions->count() . " permissions to System Administrator\n";
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
            echo "Assigned " . $billingManagerPermissions->count() . " permissions to Billing Manager\n";
        }

        // Customer Support Representative gets customer and support focused permissions
        if ($supportRep) {
            $supportPermissions = Permission::whereIn('module', [
                'System Dashboard',
                'Customer Management',
                'Support Ticket System',
            ])->orWhereIn('slug', [
                'view-customer-orders',
                'view-invoice-records',
                'view-product-listings',
            ])->get();
            $supportRep->permissions()->sync($supportPermissions->pluck('id')->toArray());
            echo "Assigned " . $supportPermissions->count() . " permissions to Customer Support Representative\n";
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
            echo "Assigned " . $financialPermissions->count() . " permissions to Financial Controller\n";
        }

        // Sales Representative gets sales and customer acquisition permissions
        if ($salesRep) {
            $salesPermissions = Permission::whereIn('module', [
                'System Dashboard',
                'Customer Management',
                'Order Processing',
                'Product Catalog',
            ])->orWhereIn('slug', [
                'view-invoice-records',
                'view-support-tickets',
            ])->get();
            $salesRep->permissions()->sync($salesPermissions->pluck('id')->toArray());
            echo "Assigned " . $salesPermissions->count() . " permissions to Sales Representative\n";
        }
    }
}
