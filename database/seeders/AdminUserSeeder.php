<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles with updated names
        $systemAdminRole = Role::where('name', 'System Administrator')->first();
        $billingManagerRole = Role::where('name', 'Billing Manager')->first();
        $supportRepRole = Role::where('name', 'Customer Support Representative')->first();
        $financialControllerRole = Role::where('name', 'Financial Controller')->first();
        $salesRepRole = Role::where('name', 'Sales Representative')->first();

        // Get departments with updated names
        $itDept = Department::where('name', 'Information Technology')->first();
        $revenueDept = Department::where('name', 'Revenue Operations')->first();
        $customerExpDept = Department::where('name', 'Customer Experience')->first();
        $financialDept = Department::where('name', 'Financial Services')->first();
        $businessDevDept = Department::where('name', 'Business Development')->first();

        // Create realistic admin user profiles
        $admins = [
            [
                'user' => [
                    'name' => 'Marcus Thompson',
                    'email' => 'marcus.thompson@billingcorp.com',
                    'password' => Hash::make('SecurePass123!'),
                ],
                'profile' => [
                    'first_name' => 'Marcus',
                    'last_name' => 'Thompson',
                    'phone' => '+1-555-0101',
                    'role_id' => $systemAdminRole->id,
                    'department_id' => $itDept->id,
                    'status' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Sarah Chen',
                    'email' => 'sarah.chen@billingcorp.com',
                    'password' => Hash::make('BillingPro456!'),
                ],
                'profile' => [
                    'first_name' => 'Sarah',
                    'last_name' => 'Chen',
                    'phone' => '+1-555-0202',
                    'role_id' => $billingManagerRole->id,
                    'department_id' => $revenueDept->id,
                    'status' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'David Rodriguez',
                    'email' => 'david.rodriguez@billingcorp.com',
                    'password' => Hash::make('Support789!'),
                ],
                'profile' => [
                    'first_name' => 'David',
                    'last_name' => 'Rodriguez',
                    'phone' => '+1-555-0303',
                    'role_id' => $supportRepRole->id,
                    'department_id' => $customerExpDept->id,
                    'status' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Jennifer Williams',
                    'email' => 'jennifer.williams@billingcorp.com',
                    'password' => Hash::make('Finance321!'),
                ],
                'profile' => [
                    'first_name' => 'Jennifer',
                    'last_name' => 'Williams',
                    'phone' => '+1-555-0404',
                    'role_id' => $financialControllerRole->id,
                    'department_id' => $financialDept->id,
                    'status' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Michael Johnson',
                    'email' => 'michael.johnson@billingcorp.com',
                    'password' => Hash::make('Sales654!'),
                ],
                'profile' => [
                    'first_name' => 'Michael',
                    'last_name' => 'Johnson',
                    'phone' => '+1-555-0505',
                    'role_id' => $salesRepRole->id,
                    'department_id' => $businessDevDept->id,
                    'status' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Lisa Anderson',
                    'email' => 'lisa.anderson@billingcorp.com',
                    'password' => Hash::make('Revenue987!'),
                ],
                'profile' => [
                    'first_name' => 'Lisa',
                    'last_name' => 'Anderson',
                    'phone' => '+1-555-0606',
                    'role_id' => $billingManagerRole->id,
                    'department_id' => $revenueDept->id,
                    'status' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Robert Kim',
                    'email' => 'robert.kim@billingcorp.com',
                    'password' => Hash::make('Customer147!'),
                ],
                'profile' => [
                    'first_name' => 'Robert',
                    'last_name' => 'Kim',
                    'phone' => '+1-555-0707',
                    'role_id' => $supportRepRole->id,
                    'department_id' => $customerExpDept->id,
                    'status' => true,
                ],
            ],
        ];

        foreach ($admins as $admin) {
            // Create the admin user profile
            $adminUser = AdminUser::create($admin['profile']);

            // Create the user with polymorphic relationship
            $user = new User($admin['user']);
            $adminUser->user()->save($user);
        }
    }
}
