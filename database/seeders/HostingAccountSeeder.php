<?php

namespace Database\Seeders;

use App\Models\HostingAccount;
use App\Models\Customer;
use App\Models\Server;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HostingAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing hosting accounts
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        HostingAccount::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get required data
        $customers = Customer::all();
        $servers = Server::all();
        $products = Product::where('type', 'hosting')->get();
        $subscriptions = Subscription::all();
        $orders = Order::all();

        if ($customers->isEmpty() || $servers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Missing required data. Please ensure customers, servers, and products exist.');
            return;
        }

        $hostingAccounts = [
            // Active Shared Hosting Accounts
            [
                'customer_id' => $customers->random()->id,
                'server_id' => $servers->where('type', 'shared')->first()?->id ?? $servers->first()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'account_number' => 'HA000001',
                'username' => 'techcorp',
                'domain' => 'techcorp.com',
                'status' => 'active',
                'provisioned_at' => Carbon::now()->subDays(45),
                'disk_usage_mb' => 2048.50,
                'disk_limit_mb' => 5120.00,
                'bandwidth_usage_mb' => 15360.75,
                'bandwidth_limit_mb' => 51200.00,
                'email_accounts' => 8,
                'email_limit' => 25,
                'databases' => 3,
                'database_limit' => 10,
                'subdomains' => 2,
                'subdomain_limit' => 10,
                'cpanel_username' => 'techcorp',
                'cpanel_domain' => 'techcorp.com',
                'backup_enabled' => true,
                'last_backup' => Carbon::now()->subDays(1),
                'ssl_enabled' => true,
                'ssl_type' => 'free',
                'setup_fee' => 0.00,
                'monthly_fee' => 9.99,
                'billing_cycle' => 'monthly',
                'next_due_date' => Carbon::now()->addDays(15),
                'notes' => 'WordPress e-commerce site with moderate traffic',
            ],
            [
                'customer_id' => $customers->random()->id,
                'server_id' => $servers->where('type', 'shared')->first()?->id ?? $servers->first()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'account_number' => 'HA000002',
                'username' => 'designstudio',
                'domain' => 'creativestudio.net',
                'status' => 'active',
                'provisioned_at' => Carbon::now()->subDays(120),
                'disk_usage_mb' => 4567.25,
                'disk_limit_mb' => 10240.00,
                'bandwidth_usage_mb' => 28672.40,
                'bandwidth_limit_mb' => 102400.00,
                'email_accounts' => 15,
                'email_limit' => 50,
                'databases' => 5,
                'database_limit' => 25,
                'subdomains' => 8,
                'subdomain_limit' => 25,
                'cpanel_username' => 'designstudio',
                'cpanel_domain' => 'creativestudio.net',
                'backup_enabled' => true,
                'last_backup' => Carbon::now()->subHours(6),
                'ssl_enabled' => true,
                'ssl_type' => 'paid',
                'setup_fee' => 0.00,
                'monthly_fee' => 19.99,
                'billing_cycle' => 'monthly',
                'next_due_date' => Carbon::now()->addDays(8),
                'notes' => 'Design agency portfolio with client galleries',
            ],
            // VPS Hosting Accounts
            [
                'customer_id' => $customers->random()->id,
                'server_id' => $servers->where('type', 'vps')->first()?->id ?? $servers->first()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'account_number' => 'HA000003',
                'username' => 'appserver01',
                'domain' => 'myapp.io',
                'status' => 'active',
                'provisioned_at' => Carbon::now()->subDays(30),
                'disk_usage_mb' => 15360.00,
                'disk_limit_mb' => 51200.00,
                'bandwidth_usage_mb' => 76800.00,
                'bandwidth_limit_mb' => 512000.00,
                'email_accounts' => 5,
                'email_limit' => 100,
                'databases' => 8,
                'database_limit' => 50,
                'subdomains' => 12,
                'subdomain_limit' => 100,
                'cpanel_username' => 'appserver01',
                'cpanel_domain' => 'myapp.io',
                'backup_enabled' => true,
                'last_backup' => Carbon::now()->subHours(12),
                'ssl_enabled' => true,
                'ssl_type' => 'custom',
                'setup_fee' => 25.00,
                'monthly_fee' => 49.99,
                'billing_cycle' => 'monthly',
                'next_due_date' => Carbon::now()->addDays(22),
                'notes' => 'Node.js application server with Redis cache',
            ],
            // Suspended Account
            [
                'customer_id' => $customers->random()->id,
                'server_id' => $servers->where('type', 'shared')->skip(1)->first()?->id ?? $servers->first()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'account_number' => 'HA000004',
                'username' => 'oldsite',
                'domain' => 'oldcompany.org',
                'status' => 'suspended',
                'suspension_reason' => 'payment',
                'provisioned_at' => Carbon::now()->subDays(200),
                'suspended_at' => Carbon::now()->subDays(5),
                'disk_usage_mb' => 1024.00,
                'disk_limit_mb' => 2048.00,
                'bandwidth_usage_mb' => 5120.00,
                'bandwidth_limit_mb' => 20480.00,
                'email_accounts' => 3,
                'email_limit' => 10,
                'databases' => 1,
                'database_limit' => 5,
                'subdomains' => 0,
                'subdomain_limit' => 5,
                'cpanel_username' => 'oldsite',
                'cpanel_domain' => 'oldcompany.org',
                'backup_enabled' => false,
                'last_backup' => Carbon::now()->subDays(10),
                'ssl_enabled' => false,
                'ssl_type' => null,
                'setup_fee' => 0.00,
                'monthly_fee' => 7.99,
                'billing_cycle' => 'monthly',
                'next_due_date' => Carbon::now()->subDays(5),
                'notes' => 'Suspended due to non-payment - customer contacted',
            ],
            // Pending Setup Account
            [
                'customer_id' => $customers->random()->id,
                'server_id' => $servers->where('type', 'shared')->first()?->id ?? $servers->first()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'account_number' => 'HA000005',
                'username' => 'newbusiness',
                'domain' => 'newbusiness.com',
                'status' => 'pending',
                'disk_usage_mb' => 0.00,
                'disk_limit_mb' => 5120.00,
                'bandwidth_usage_mb' => 0.00,
                'bandwidth_limit_mb' => 51200.00,
                'email_accounts' => 0,
                'email_limit' => 25,
                'databases' => 0,
                'database_limit' => 10,
                'subdomains' => 0,
                'subdomain_limit' => 10,
                'cpanel_username' => 'newbusiness',
                'cpanel_domain' => 'newbusiness.com',
                'backup_enabled' => true,
                'ssl_enabled' => false,
                'setup_fee' => 0.00,
                'monthly_fee' => 9.99,
                'billing_cycle' => 'monthly',
                'next_due_date' => Carbon::now()->addDays(30),
                'notes' => 'New account awaiting DNS propagation',
            ],
            // Dedicated Server Account
            [
                'customer_id' => $customers->random()->id,
                'server_id' => $servers->where('type', 'dedicated')->first()?->id ?? $servers->first()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'account_number' => 'HA000006',
                'username' => 'enterprise',
                'domain' => 'enterprise-corp.com',
                'status' => 'active',
                'provisioned_at' => Carbon::now()->subDays(90),
                'disk_usage_mb' => 307200.00, // 300GB
                'disk_limit_mb' => 1024000.00, // 1TB
                'bandwidth_usage_mb' => 2048000.00, // 2TB
                'bandwidth_limit_mb' => 10240000.00, // 10TB
                'email_accounts' => 50,
                'email_limit' => 1000,
                'databases' => 25,
                'database_limit' => 100,
                'subdomains' => 45,
                'subdomain_limit' => 500,
                'cpanel_username' => 'enterprise',
                'cpanel_domain' => 'enterprise-corp.com',
                'backup_enabled' => true,
                'last_backup' => Carbon::now()->subHours(2),
                'ssl_enabled' => true,
                'ssl_type' => 'custom',
                'setup_fee' => 99.00,
                'monthly_fee' => 199.99,
                'billing_cycle' => 'monthly',
                'next_due_date' => Carbon::now()->addDays(12),
                'notes' => 'Enterprise client with high-traffic e-commerce platform',
            ],
        ];

        foreach ($hostingAccounts as $accountData) {
            HostingAccount::create($accountData);
        }

        $this->command->info('Created ' . count($hostingAccounts) . ' hosting accounts with realistic usage data.');
    }
}
