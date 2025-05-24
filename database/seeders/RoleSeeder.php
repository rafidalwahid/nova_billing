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
                'name' => 'System Administrator',
                'description' => 'Complete system access with full administrative privileges including user management, system configuration, and security settings',
                'is_system' => true,
            ],
            [
                'name' => 'Billing Manager',
                'description' => 'Oversees all billing operations, invoice management, payment processing, and financial reporting with supervisory access',
                'is_system' => true,
            ],
            [
                'name' => 'Customer Support Representative',
                'description' => 'Handles customer inquiries, ticket management, account assistance, and basic billing support with customer-focused permissions',
                'is_system' => true,
            ],
            [
                'name' => 'Financial Controller',
                'description' => 'Manages financial operations, revenue tracking, payment reconciliation, and advanced billing analytics with financial oversight',
                'is_system' => true,
            ],
            [
                'name' => 'Sales Representative',
                'description' => 'Focuses on customer acquisition, order processing, product management, and sales-related activities with limited administrative access',
                'is_system' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
