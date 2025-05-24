<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'description' => 'Full system access',
                'is_system' => true,
            ],
            [
                'name' => 'Administrator',
                'description' => 'Admin access with some restrictions',
                'is_system' => true,
            ],
            [
                'name' => 'Support Staff',
                'description' => 'Access to support tickets and customer data',
                'is_system' => true,
            ],
            [
                'name' => 'Billing Staff',
                'description' => 'Access to billing and invoices',
                'is_system' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
