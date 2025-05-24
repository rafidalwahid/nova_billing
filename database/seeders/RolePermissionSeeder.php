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
        // Get all roles
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $administrator = Role::where('name', 'Administrator')->first();
        $supportStaff = Role::where('name', 'Support Staff')->first();
        $billingStaff = Role::where('name', 'Billing Staff')->first();

        // Get all permissions
        $allPermissions = Permission::all();

        // Super Admin gets ALL permissions
        if ($superAdmin) {
            $superAdmin->permissions()->sync($allPermissions->pluck('id')->toArray());
            echo "Assigned " . $allPermissions->count() . " permissions to Super Admin\n";
        }

        // Administrator gets most permissions except some sensitive ones
        if ($administrator) {
            $adminPermissions = Permission::whereNotIn('slug', [
                'delete-staff',
                'delete-roles',
            ])->get();
            $administrator->permissions()->sync($adminPermissions->pluck('id')->toArray());
            echo "Assigned " . $adminPermissions->count() . " permissions to Administrator\n";
        }

        // Support Staff gets customer and ticket related permissions
        if ($supportStaff) {
            $supportPermissions = Permission::whereIn('module', [
                'Dashboard',
                'Customers',
                'Tickets',
            ])->orWhereIn('slug', [
                'view-orders',
                'view-invoices',
            ])->get();
            $supportStaff->permissions()->sync($supportPermissions->pluck('id')->toArray());
            echo "Assigned " . $supportPermissions->count() . " permissions to Support Staff\n";
        }

        // Billing Staff gets billing and invoice related permissions
        if ($billingStaff) {
            $billingPermissions = Permission::whereIn('module', [
                'Dashboard',
                'Customers',
                'Orders',
                'Invoices',
                'Products',
            ])->get();
            $billingStaff->permissions()->sync($billingPermissions->pluck('id')->toArray());
            echo "Assigned " . $billingPermissions->count() . " permissions to Billing Staff\n";
        }
    }
}
