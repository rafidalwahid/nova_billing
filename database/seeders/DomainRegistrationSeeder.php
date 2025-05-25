<?php

namespace Database\Seeders;

use App\Models\DomainRegistration;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DomainRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing domain registrations
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DomainRegistration::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get required data
        $customers = Customer::all();
        $products = Product::where('type', 'domain')->get();
        $subscriptions = Subscription::all();
        $orders = Order::all();

        if ($customers->isEmpty()) {
            $this->command->warn('No customers found. Please run CustomerSeeder first.');
            return;
        }

        // Create a domain product if none exists
        if ($products->isEmpty()) {
            $domainProduct = Product::create([
                'name' => 'Domain Registration',
                'type' => 'domain',
                'description' => 'Domain name registration service',
                'is_active' => true,
            ]);
            $products = collect([$domainProduct]);
        }

        $domainRegistrations = [
            // Active Domain - Recently Registered
            [
                'customer_id' => $customers->random()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'domain_name' => 'techcorp',
                'tld' => '.com',
                'registrar' => 'namecheap',
                'status' => 'active',
                'registration_date' => Carbon::now()->subMonths(2), // 2 months ago
                'expiration_date' => Carbon::now()->subMonths(2)->addYear(), // 1 year from registration = 10 months from now
                'registration_period' => 1,
                'registrar_domain_id' => 'NC_' . mt_rand(100000, 999999),
                'nameservers' => [
                    'ns1.hosting.com',
                    'ns2.hosting.com',
                ],
                'dns_management' => true,
                'whois_privacy' => true,
                'registrant_contact' => [
                    'name' => 'John Smith',
                    'organization' => 'TechCorp Inc.',
                    'email' => 'admin@techcorp.com',
                    'phone' => '+1.5551234567',
                    'address' => '123 Tech Street',
                    'city' => 'San Francisco',
                    'state' => 'CA',
                    'postal_code' => '94105',
                    'country' => 'US',
                ],
                'auto_renew' => true,
                'registration_fee' => 12.99,
                'renewal_fee' => 14.99,
                'next_due_date' => Carbon::now()->addMonths(10),
                'transfer_lock' => true,
                'notes' => 'Primary business domain with privacy protection',
            ],
            [
                'customer_id' => $customers->random()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'domain_name' => 'creativestudio',
                'tld' => '.net',
                'registrar' => 'godaddy',
                'status' => 'active',
                'registration_date' => Carbon::now()->subMonths(8),
                'expiration_date' => Carbon::now()->addMonths(4),
                'registration_period' => 1,
                'registrar_domain_id' => 'GD_' . mt_rand(100000, 999999),
                'nameservers' => [
                    'ns1.godaddy.com',
                    'ns2.godaddy.com',
                ],
                'dns_management' => false,
                'whois_privacy' => true,
                'registrant_contact' => [
                    'name' => 'Sarah Johnson',
                    'organization' => 'Creative Studio LLC',
                    'email' => 'contact@creativestudio.net',
                    'phone' => '+1.5559876543',
                    'address' => '456 Design Ave',
                    'city' => 'New York',
                    'state' => 'NY',
                    'postal_code' => '10001',
                    'country' => 'US',
                ],
                'auto_renew' => true,
                'registration_fee' => 15.99,
                'renewal_fee' => 17.99,
                'next_due_date' => Carbon::now()->addMonths(3),
                'transfer_lock' => true,
                'email_forwarding' => true,
                'notes' => 'Design agency portfolio domain',
            ],
            // Domain Expiring Soon
            [
                'customer_id' => $customers->random()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'domain_name' => 'myapp',
                'tld' => '.io',
                'registrar' => 'namecheap',
                'status' => 'active',
                'registration_date' => Carbon::now()->subMonths(11),
                'expiration_date' => Carbon::now()->addDays(15), // Expiring soon
                'registration_period' => 1,
                'registrar_domain_id' => 'NC_' . mt_rand(100000, 999999),
                'nameservers' => [
                    'ns1.cloudflare.com',
                    'ns2.cloudflare.com',
                ],
                'dns_management' => true,
                'whois_privacy' => false,
                'registrant_contact' => [
                    'name' => 'Mike Developer',
                    'organization' => 'App Solutions Inc.',
                    'email' => 'mike@myapp.io',
                    'phone' => '+1.5551112222',
                    'address' => '789 Code Lane',
                    'city' => 'Austin',
                    'state' => 'TX',
                    'postal_code' => '73301',
                    'country' => 'US',
                ],
                'auto_renew' => false, // Manual renewal
                'registration_fee' => 39.99,
                'renewal_fee' => 39.99,
                'next_due_date' => Carbon::now()->addDays(10),
                'transfer_lock' => false,
                'notes' => 'Application domain - renewal reminder sent',
            ],
            // Recently Expired Domain
            [
                'customer_id' => $customers->random()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'domain_name' => 'oldcompany',
                'tld' => '.org',
                'registrar' => 'godaddy',
                'status' => 'expired',
                'registration_date' => Carbon::now()->subYears(2),
                'expiration_date' => Carbon::now()->subDays(3), // Recently expired
                'registration_period' => 1,
                'registrar_domain_id' => 'GD_' . mt_rand(100000, 999999),
                'nameservers' => [
                    'ns1.godaddy.com',
                    'ns2.godaddy.com',
                ],
                'dns_management' => false,
                'whois_privacy' => true,
                'registrant_contact' => [
                    'name' => 'Robert Wilson',
                    'organization' => 'Old Company Corp',
                    'email' => 'admin@oldcompany.org',
                    'phone' => '+1.5553334444',
                    'address' => '321 Business Blvd',
                    'city' => 'Chicago',
                    'state' => 'IL',
                    'postal_code' => '60601',
                    'country' => 'US',
                ],
                'auto_renew' => false,
                'registration_fee' => 9.99,
                'renewal_fee' => 11.99,
                'next_due_date' => Carbon::now()->subDays(3),
                'transfer_lock' => true,
                'notes' => 'Domain expired - customer notified, grace period active',
            ],
            // Pending Transfer Domain
            [
                'customer_id' => $customers->random()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'domain_name' => 'newbusiness',
                'tld' => '.com',
                'registrar' => 'namecheap',
                'status' => 'pending',
                'registration_date' => null, // Transfer in progress
                'expiration_date' => Carbon::now()->addMonths(8),
                'registration_period' => 1,
                'registrar_domain_id' => null,
                'auth_code' => 'AUTH' . strtoupper(substr(md5(mt_rand()), 0, 8)),
                'nameservers' => [
                    'ns1.hosting.com',
                    'ns2.hosting.com',
                ],
                'dns_management' => true,
                'whois_privacy' => true,
                'registrant_contact' => [
                    'name' => 'Lisa Chen',
                    'organization' => 'New Business LLC',
                    'email' => 'info@newbusiness.com',
                    'phone' => '+1.5557778888',
                    'address' => '654 Startup St',
                    'city' => 'Seattle',
                    'state' => 'WA',
                    'postal_code' => '98101',
                    'country' => 'US',
                ],
                'auto_renew' => true,
                'registration_fee' => 0.00, // Transfer fee
                'renewal_fee' => 12.99,
                'next_due_date' => Carbon::now()->addMonths(7),
                'transfer_lock' => false,
                'transfer_requested_at' => Carbon::now()->subDays(2),
                'transfer_status' => 'pending',
                'notes' => 'Domain transfer in progress from previous registrar',
            ],
            // Premium Domain - Should be EXPIRED to demonstrate the issue
            [
                'customer_id' => $customers->random()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'domain_name' => 'enterprise-corp',
                'tld' => '.com',
                'registrar' => 'namecheap',
                'status' => 'active', // This will be wrong - should be expired
                'registration_date' => Carbon::now()->subYears(2)->subMonths(3), // 2 years 3 months ago
                'expiration_date' => Carbon::now()->subYears(1)->subMonths(3), // 1 year 3 months ago (EXPIRED)
                'registration_period' => 1,
                'registrar_domain_id' => 'NC_' . mt_rand(100000, 999999),
                'nameservers' => [
                    'ns1.enterprise-corp.com',
                    'ns2.enterprise-corp.com',
                ],
                'dns_management' => true,
                'whois_privacy' => false, // Corporate domain
                'registrant_contact' => [
                    'name' => 'David Enterprise',
                    'organization' => 'Enterprise Corporation',
                    'email' => 'domains@enterprise-corp.com',
                    'phone' => '+1.5550001111',
                    'address' => '1000 Corporate Plaza',
                    'city' => 'Los Angeles',
                    'state' => 'CA',
                    'postal_code' => '90210',
                    'country' => 'US',
                ],
                'auto_renew' => true,
                'registration_fee' => 12.99,
                'renewal_fee' => 12.99,
                'next_due_date' => Carbon::now()->subYears(1)->subMonths(3)->subDays(30), // 30 days before expiration
                'transfer_lock' => true,
                'email_forwarding' => false,
                'url_forwarding' => false,
                'additional_services' => [
                    'ssl_certificate' => true,
                    'email_hosting' => true,
                    'dns_management' => true,
                ],
                'notes' => 'Corporate domain with premium DNS and email services',
            ],
        ];

        foreach ($domainRegistrations as $domainData) {
            DomainRegistration::create($domainData);
        }

        $this->command->info('Created ' . count($domainRegistrations) . ' domain registrations with realistic data.');
    }
}
