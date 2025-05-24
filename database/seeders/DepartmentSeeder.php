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
                'name' => 'Sales',
                'description' => 'Sales department',
                'email' => 'sales@example.com',
            ],
            [
                'name' => 'Technical Support',
                'description' => 'Technical support team',
                'email' => 'support@example.com',
            ],
            [
                'name' => 'Billing',
                'description' => 'Billing and payments department',
                'email' => 'billing@example.com',
            ],
            [
                'name' => 'Management',
                'description' => 'Management team',
                'email' => 'management@example.com',
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
