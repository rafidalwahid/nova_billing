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
        // Get the Super Admin role
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $adminRole = Role::where('name', 'Administrator')->first();
        $supportRole = Role::where('name', 'Support Staff')->first();
        $billingRole = Role::where('name', 'Billing Staff')->first();
        
        // Get departments
        $managementDept = Department::where('name', 'Management')->first();
        $supportDept = Department::where('name', 'Technical Support')->first();
        $billingDept = Department::where('name', 'Billing')->first();
        
        // Create admin users
        $admins = [
            [
                'user' => [
                    'name' => 'Super Admin',
                    'email' => 'superadmin@example.com',
                    'password' => Hash::make('password'),
                ],
                'profile' => [
                    'first_name' => 'Super',
                    'last_name' => 'Admin',
                    'phone' => '1234567890',
                    'role_id' => $superAdminRole->id,
                    'department_id' => $managementDept->id,
                    'status' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Admin User',
                    'email' => 'admin@example.com',
                    'password' => Hash::make('password'),
                ],
                'profile' => [
                    'first_name' => 'Admin',
                    'last_name' => 'User',
                    'phone' => '1234567891',
                    'role_id' => $adminRole->id,
                    'department_id' => $managementDept->id,
                    'status' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Support Staff',
                    'email' => 'support@example.com',
                    'password' => Hash::make('password'),
                ],
                'profile' => [
                    'first_name' => 'Support',
                    'last_name' => 'Staff',
                    'phone' => '1234567892',
                    'role_id' => $supportRole->id,
                    'department_id' => $supportDept->id,
                    'status' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Billing Staff',
                    'email' => 'billing@example.com',
                    'password' => Hash::make('password'),
                ],
                'profile' => [
                    'first_name' => 'Billing',
                    'last_name' => 'Staff',
                    'phone' => '1234567893',
                    'role_id' => $billingRole->id,
                    'department_id' => $billingDept->id,
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
