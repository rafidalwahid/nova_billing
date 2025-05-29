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

        // Get available servers for each type
        $availableSharedServers = $servers->where('type', 'shared')->filter(function($server) {
            return $server->hasCapacity();
        });
        $availableVpsServers = $servers->where('type', 'vps')->filter(function($server) {
            return $server->hasCapacity();
        });
        $availableDedicatedServers = $servers->where('type', 'dedicated')->filter(function($server) {
            return $server->hasCapacity();
        });

        $hostingAccounts = [];

        // Only create accounts if we have available servers
        if ($availableSharedServers->isNotEmpty()) {
            $hostingAccounts[] = [
                'customer_id' => $customers->random()->id,
                'server_id' => $availableSharedServers->first()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'account_number' => 'HA000001',
                'username' => 'techcorp',
                'domain' => 'techcorp.com',
                'status' => 'active',
                'provisioned_at' => Carbon::now()->subDays(45),
                'disk_usage_mb' => 2048.50,
                'bandwidth_usage_mb' => 15360.75,
                'email_accounts' => 8,
                'databases' => 3,
                'subdomains' => 2,
                'cpanel_username' => 'techcorp',
                'cpanel_domain' => 'techcorp.com',
                'backup_enabled' => true,
                'last_backup' => Carbon::now()->subDays(1),
                'ssl_enabled' => true,
                'ssl_type' => 'free',
                'notes' => 'WordPress e-commerce site with moderate traffic',
            ];
        }

        if ($availableSharedServers->count() > 1) {
            $hostingAccounts[] = [
                'customer_id' => $customers->random()->id,
                'server_id' => $availableSharedServers->skip(1)->first()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'account_number' => 'HA000002',
                'username' => 'designstudio',
                'domain' => 'creativestudio.net',
                'status' => 'active',
                'provisioned_at' => Carbon::now()->subDays(120),
                'disk_usage_mb' => 4567.25,
                'bandwidth_usage_mb' => 28672.40,
                'email_accounts' => 15,
                'databases' => 5,
                'subdomains' => 8,
                'cpanel_username' => 'designstudio',
                'cpanel_domain' => 'creativestudio.net',
                'backup_enabled' => true,
                'last_backup' => Carbon::now()->subHours(6),
                'ssl_enabled' => true,
                'ssl_type' => 'paid',
                'notes' => 'Design agency portfolio with client galleries',
            ];
        }

        // VPS Hosting Accounts
        if ($availableVpsServers->isNotEmpty()) {
            $hostingAccounts[] = [
                'customer_id' => $customers->random()->id,
                'server_id' => $availableVpsServers->first()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'account_number' => 'HA000003',
                'username' => 'appserver01',
                'domain' => 'myapp.io',
                'status' => 'active',
                'provisioned_at' => Carbon::now()->subDays(30),
                'disk_usage_mb' => 15360.00,
                'bandwidth_usage_mb' => 76800.00,
                'email_accounts' => 5,
                'databases' => 8,
                'subdomains' => 12,
                'cpanel_username' => 'appserver01',
                'cpanel_domain' => 'myapp.io',
                'backup_enabled' => true,
                'last_backup' => Carbon::now()->subHours(12),
                'ssl_enabled' => true,
                'ssl_type' => 'custom',
                'notes' => 'Node.js application server with Redis cache',
            ];
        }

        // Suspended Account (use any available shared server)
        if ($availableSharedServers->isNotEmpty()) {
            $hostingAccounts[] = [
                'customer_id' => $customers->random()->id,
                'server_id' => $availableSharedServers->random()->id,
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
                'bandwidth_usage_mb' => 5120.00,
                'email_accounts' => 3,
                'databases' => 1,
                'subdomains' => 0,
                'cpanel_username' => 'oldsite',
                'cpanel_domain' => 'oldcompany.org',
                'backup_enabled' => false,
                'last_backup' => Carbon::now()->subDays(10),
                'ssl_enabled' => false,
                'ssl_type' => null,
                'notes' => 'Suspended due to non-payment - customer contacted',
            ];
        }

        // Pending Setup Account
        if ($availableSharedServers->isNotEmpty()) {
            $hostingAccounts[] = [
                'customer_id' => $customers->random()->id,
                'server_id' => $availableSharedServers->random()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'account_number' => 'HA000005',
                'username' => 'newbusiness',
                'domain' => 'newbusiness.com',
                'status' => 'pending',
                'disk_usage_mb' => 0.00,
                'bandwidth_usage_mb' => 0.00,
                'email_accounts' => 0,
                'databases' => 0,
                'subdomains' => 0,
                'cpanel_username' => 'newbusiness',
                'cpanel_domain' => 'newbusiness.com',
                'backup_enabled' => true,
                'ssl_enabled' => false,
                'notes' => 'New account awaiting DNS propagation',
            ];
        }

        // Dedicated Server Account (only if available)
        if ($availableDedicatedServers->isNotEmpty()) {
            $hostingAccounts[] = [
                'customer_id' => $customers->random()->id,
                'server_id' => $availableDedicatedServers->first()->id,
                'product_id' => $products->first()->id,
                'subscription_id' => $subscriptions->isNotEmpty() ? $subscriptions->random()->id : null,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'account_number' => 'HA000006',
                'username' => 'enterprise',
                'domain' => 'enterprise-corp.com',
                'status' => 'active',
                'provisioned_at' => Carbon::now()->subDays(90),
                'disk_usage_mb' => 307200.00, // 300GB
                'bandwidth_usage_mb' => 2048000.00, // 2TB
                'email_accounts' => 50,
                'databases' => 25,
                'subdomains' => 45,
                'cpanel_username' => 'enterprise',
                'cpanel_domain' => 'enterprise-corp.com',
                'backup_enabled' => true,
                'last_backup' => Carbon::now()->subHours(2),
                'ssl_enabled' => true,
                'ssl_type' => 'custom',
                'notes' => 'Enterprise client with high-traffic e-commerce platform',
            ];
        }

        foreach ($hostingAccounts as $accountData) {
            HostingAccount::create($accountData);
        }

        $this->command->info('Created ' . count($hostingAccounts) . ' hosting accounts with realistic usage data.');
    }
}
