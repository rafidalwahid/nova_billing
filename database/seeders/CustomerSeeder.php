<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample customers
        $customers = [
            [
                'user' => [
                    'name' => 'John Doe',
                    'email' => 'john.doe@customer.com',
                    'password' => Hash::make('password'),
                ],
                'profile' => [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'phone' => '9876543210',
                    'address' => '123 Main Street',
                    'city' => 'New York',
                    'state' => 'NY',
                    'country' => 'USA',
                    'postal_code' => '10001',
                    'company_name' => 'John Doe Enterprises',
                    'status' => true,
                    'last_login' => now(),
                ],
            ],
            [
                'user' => [
                    'name' => 'Jane Smith',
                    'email' => 'jane.smith@techstartup.com',
                    'password' => Hash::make('password'),
                ],
                'profile' => [
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'phone' => '9876543211',
                    'address' => '456 Elm Street',
                    'city' => 'Los Angeles',
                    'state' => 'CA',
                    'country' => 'USA',
                    'postal_code' => '90001',
                    'company_name' => 'Jane Smith LLC',
                    'status' => true,
                    'last_login' => now(),
                ],
            ],
            [
                'user' => [
                    'name' => 'Alex Johnson',
                    'email' => 'alex.johnson@consulting.biz',
                    'password' => Hash::make('password'),
                ],
                'profile' => [
                    'first_name' => 'Alex',
                    'last_name' => 'Johnson',
                    'phone' => '9876543212',
                    'address' => '789 Oak Avenue',
                    'city' => 'Chicago',
                    'state' => 'IL',
                    'country' => 'USA',
                    'postal_code' => '60007',
                    'company_name' => 'AJ Consulting',
                    'status' => true,
                    'last_login' => now(),
                ],
            ],
            [
                'user' => [
                    'name' => 'Maria Garcia',
                    'email' => 'maria.garcia@hostingpro.net',
                    'password' => Hash::make('password'),
                ],
                'profile' => [
                    'first_name' => 'Maria',
                    'last_name' => 'Garcia',
                    'phone' => '9876543213',
                    'address' => '101 Pine Street',
                    'city' => 'Miami',
                    'state' => 'FL',
                    'country' => 'USA',
                    'postal_code' => '33101',
                    'company_name' => 'Garcia Hosting',
                    'status' => true,
                    'last_login' => now(),
                ],
            ],
            [
                'user' => [
                    'name' => 'David Lee',
                    'email' => 'david.lee@leetech.org',
                    'password' => Hash::make('password'),
                ],
                'profile' => [
                    'first_name' => 'David',
                    'last_name' => 'Lee',
                    'phone' => '9876543214',
                    'address' => '222 Maple Drive',
                    'city' => 'Seattle',
                    'state' => 'WA',
                    'country' => 'USA',
                    'postal_code' => '98101',
                    'company_name' => 'Lee Technologies',
                    'status' => false, // Inactive customer for testing
                    'last_login' => now()->subDays(90), // Last login 90 days ago
                ],
            ],
        ];

        foreach ($customers as $customer) {
            // Create the customer profile
            $customerModel = Customer::create($customer['profile']);

            // Create the user with polymorphic relationship
            $user = new User($customer['user']);
            $customerModel->user()->save($user);
        }
    }
}
