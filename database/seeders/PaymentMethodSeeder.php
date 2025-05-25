<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'Credit Card',
                'gateway' => 'stripe',
                'is_active' => true,
                'display_order' => 1,
                'description' => 'Pay securely with your credit or debit card via Stripe',
                'icon' => 'credit-card',
                'config' => [
                    'public_key' => 'pk_test_...',
                    'secret_key' => 'sk_test_...',
                    'webhook_secret' => 'whsec_...',
                ],
            ],
            [
                'name' => 'PayPal',
                'gateway' => 'paypal',
                'is_active' => true,
                'display_order' => 2,
                'description' => 'Pay with your PayPal account or credit card',
                'icon' => 'paypal',
                'config' => [
                    'client_id' => 'your_paypal_client_id',
                    'client_secret' => 'your_paypal_client_secret',
                    'mode' => 'sandbox', // or 'live'
                ],
            ],
            [
                'name' => 'Bank Transfer',
                'gateway' => 'bank_transfer',
                'is_active' => true,
                'display_order' => 3,
                'description' => 'Transfer funds directly from your bank account',
                'icon' => 'bank',
                'config' => [
                    'bank_name' => 'Your Bank Name',
                    'account_number' => '1234567890',
                    'routing_number' => '123456789',
                    'account_name' => 'Your Company Name',
                ],
            ],
            [
                'name' => 'Check Payment',
                'gateway' => 'check',
                'is_active' => true,
                'display_order' => 4,
                'description' => 'Mail a check to our business address',
                'icon' => 'check',
                'config' => [
                    'payable_to' => 'Your Company Name',
                    'mailing_address' => '123 Business St, City, State 12345',
                    'processing_time' => '5-7 business days',
                ],
            ],
            [
                'name' => 'Cash Payment',
                'gateway' => 'cash',
                'is_active' => false,
                'display_order' => 5,
                'description' => 'Pay with cash at our office location',
                'icon' => 'cash',
                'config' => [
                    'office_address' => '123 Business St, City, State 12345',
                    'office_hours' => 'Mon-Fri 9AM-5PM',
                ],
            ],
            [
                'name' => 'Manual Payment',
                'gateway' => 'manual',
                'is_active' => true,
                'display_order' => 6,
                'description' => 'Manual payment processing by staff',
                'icon' => 'manual',
                'config' => [
                    'requires_approval' => true,
                    'auto_complete' => false,
                ],
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }

        $this->command->info('Created ' . count($paymentMethods) . ' payment methods');
    }
}
