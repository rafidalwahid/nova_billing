<?php

namespace Database\Seeders;

use App\Models\Server;
use App\Models\ServerGroup;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing servers (handle foreign key constraints)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Server::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get server groups
        $serverGroups = ServerGroup::all();

        if ($serverGroups->isEmpty()) {
            $this->command->warn('No server groups found. Please run ServerGroupSeeder first.');
            return;
        }

        $servers = [
            // Shared Hosting Servers
            [
                'server_group_id' => $serverGroups->where('name', 'Shared Hosting - US East')->first()?->id ?? $serverGroups->first()->id,
                'name' => 'Web Server 01',
                'hostname' => 'web01.hosting.com',
                'ip_address' => '192.168.1.10',
                'port' => 22,
                'type' => 'shared',
                'os' => 'linux',
                'control_panel' => 'cPanel',
                'username' => 'root',
                'status' => 'active',
                'is_monitored' => true,
                'last_ping' => Carbon::now()->subMinutes(2),
                'cpu_usage' => 45.2,
                'memory_usage' => 62.8,
                'disk_usage' => 38.5,
                'uptime_seconds' => 2592000, // 30 days
                'max_accounts' => 150,
                'current_accounts' => 87,
                'monthly_bandwidth_gb' => 5000.00,
                'disk_space_gb' => 2000.00,
                'notes' => 'Primary shared hosting server for US East region',
            ],
            [
                'server_group_id' => $serverGroups->where('name', 'Shared Hosting - US East')->first()?->id ?? $serverGroups->first()->id,
                'name' => 'Web Server 02',
                'hostname' => 'web02.hosting.com',
                'ip_address' => '192.168.1.11',
                'port' => 22,
                'type' => 'shared',
                'os' => 'linux',
                'control_panel' => 'cPanel',
                'username' => 'root',
                'status' => 'active',
                'is_monitored' => true,
                'last_ping' => Carbon::now()->subMinutes(1),
                'cpu_usage' => 32.1,
                'memory_usage' => 55.3,
                'disk_usage' => 42.7,
                'uptime_seconds' => 1728000, // 20 days
                'max_accounts' => 150,
                'current_accounts' => 64,
                'monthly_bandwidth_gb' => 5000.00,
                'disk_space_gb' => 2000.00,
                'notes' => 'Secondary shared hosting server for load balancing',
            ],
            // VPS Servers
            [
                'server_group_id' => $serverGroups->where('name', 'VPS Hosting - US West')->first()?->id ?? $serverGroups->first()->id,
                'name' => 'VPS Node 01',
                'hostname' => 'vps01.hosting.com',
                'ip_address' => '192.168.2.10',
                'port' => 22,
                'type' => 'vps',
                'os' => 'linux',
                'control_panel' => 'Virtualizor',
                'username' => 'root',
                'status' => 'active',
                'is_monitored' => true,
                'last_ping' => Carbon::now()->subMinutes(3),
                'cpu_usage' => 68.4,
                'memory_usage' => 74.2,
                'disk_usage' => 56.8,
                'uptime_seconds' => 5184000, // 60 days
                'max_accounts' => 50,
                'current_accounts' => 34,
                'monthly_bandwidth_gb' => 10000.00,
                'disk_space_gb' => 4000.00,
                'notes' => 'Primary VPS node with SSD storage',
            ],
            [
                'server_group_id' => $serverGroups->where('name', 'VPS Hosting - US West')->first()?->id ?? $serverGroups->first()->id,
                'name' => 'VPS Node 02',
                'hostname' => 'vps02.hosting.com',
                'ip_address' => '192.168.2.11',
                'port' => 22,
                'type' => 'vps',
                'os' => 'linux',
                'control_panel' => 'Virtualizor',
                'username' => 'root',
                'status' => 'maintenance',
                'is_monitored' => true,
                'last_ping' => Carbon::now()->subHours(2),
                'cpu_usage' => 15.2,
                'memory_usage' => 28.5,
                'disk_usage' => 34.1,
                'uptime_seconds' => 432000, // 5 days
                'max_accounts' => 50,
                'current_accounts' => 12,
                'monthly_bandwidth_gb' => 10000.00,
                'disk_space_gb' => 4000.00,
                'notes' => 'Under maintenance for hardware upgrade',
            ],
            // Dedicated Servers
            [
                'server_group_id' => $serverGroups->where('name', 'Dedicated Servers - Premium')->first()?->id ?? $serverGroups->first()->id,
                'name' => 'Dedicated Server 01',
                'hostname' => 'dedicated01.hosting.com',
                'ip_address' => '192.168.3.10',
                'port' => 22,
                'type' => 'dedicated',
                'os' => 'linux',
                'control_panel' => 'cPanel',
                'username' => 'root',
                'status' => 'active',
                'is_monitored' => true,
                'last_ping' => Carbon::now()->subMinutes(1),
                'cpu_usage' => 23.7,
                'memory_usage' => 41.2,
                'disk_usage' => 28.9,
                'uptime_seconds' => 7776000, // 90 days
                'max_accounts' => 1,
                'current_accounts' => 1,
                'monthly_bandwidth_gb' => 50000.00,
                'disk_space_gb' => 10000.00,
                'notes' => 'High-performance dedicated server for enterprise clients',
            ],
            // Cloud Servers
            [
                'server_group_id' => $serverGroups->where('name', 'Cloud Hosting - Global')->first()?->id ?? $serverGroups->first()->id,
                'name' => 'Cloud Instance 01',
                'hostname' => 'cloud01.hosting.com',
                'ip_address' => '192.168.4.10',
                'port' => 22,
                'type' => 'cloud',
                'os' => 'linux',
                'control_panel' => 'Plesk',
                'username' => 'ubuntu',
                'status' => 'active',
                'is_monitored' => true,
                'last_ping' => Carbon::now()->subMinutes(1),
                'cpu_usage' => 52.3,
                'memory_usage' => 67.8,
                'disk_usage' => 45.6,
                'uptime_seconds' => 1296000, // 15 days
                'max_accounts' => 25,
                'current_accounts' => 18,
                'monthly_bandwidth_gb' => 15000.00,
                'disk_space_gb' => 1000.00,
                'notes' => 'Auto-scaling cloud instance for dynamic workloads',
            ],
            [
                'server_group_id' => $serverGroups->where('name', 'Reseller Hosting')->first()?->id ?? $serverGroups->first()->id,
                'name' => 'Reseller Server 01',
                'hostname' => 'reseller01.hosting.com',
                'ip_address' => '192.168.5.10',
                'port' => 22,
                'type' => 'shared',
                'os' => 'linux',
                'control_panel' => 'cPanel',
                'username' => 'root',
                'status' => 'active',
                'is_monitored' => true,
                'last_ping' => Carbon::now()->subMinutes(4),
                'cpu_usage' => 38.9,
                'memory_usage' => 58.4,
                'disk_usage' => 51.2,
                'uptime_seconds' => 3456000, // 40 days
                'max_accounts' => 200,
                'current_accounts' => 142,
                'monthly_bandwidth_gb' => 8000.00,
                'disk_space_gb' => 3000.00,
                'notes' => 'Dedicated server for reseller hosting packages',
            ],
        ];

        foreach ($servers as $serverData) {
            Server::create($serverData);
        }

        $this->command->info('Created ' . count($servers) . ' servers with realistic monitoring data.');
    }
}
