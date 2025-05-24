<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Information Technology',
                'description' => 'System administration, infrastructure management, security, and technical operations for the billing platform',
                'email' => 'it@billingcorp.com',
            ],
            [
                'name' => 'Revenue Operations',
                'description' => 'Billing processes, invoice generation, payment processing, and revenue cycle management',
                'email' => 'revenue@billingcorp.com',
            ],
            [
                'name' => 'Customer Experience',
                'description' => 'Customer support, account management, issue resolution, and client relationship maintenance',
                'email' => 'support@billingcorp.com',
            ],
            [
                'name' => 'Financial Services',
                'description' => 'Financial analysis, accounting, payment reconciliation, and financial reporting and compliance',
                'email' => 'finance@billingcorp.com',
            ],
            [
                'name' => 'Business Development',
                'description' => 'Sales operations, client acquisition, product promotion, and market expansion activities',
                'email' => 'sales@billingcorp.com',
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
