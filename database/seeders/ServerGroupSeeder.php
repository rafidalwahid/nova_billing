<?php

namespace Database\Seeders;

use App\Models\ServerGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing server groups (handle foreign key constraints)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ServerGroup::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create realistic server groups for hosting business
        $serverGroups = [
            [
                'name' => 'Shared Hosting - US East',
                'description' => 'High-performance shared hosting servers located in US East Coast data centers. Optimized for WordPress, PHP, and general web hosting.',
                'fill_method' => 'round_robin',
                'is_active' => true,
            ],
            [
                'name' => 'Shared Hosting - US West',
                'description' => 'Shared hosting servers in US West Coast data centers. Perfect for customers targeting Pacific region with low latency requirements.',
                'fill_method' => 'least_used',
                'is_active' => true,
            ],
            [
                'name' => 'VPS Hosting - Premium',
                'description' => 'Virtual Private Server hosting on premium hardware with SSD storage and dedicated resources. Ideal for growing businesses.',
                'fill_method' => 'least_used',
                'is_active' => true,
            ],
            [
                'name' => 'Dedicated Servers - Enterprise',
                'description' => 'High-end dedicated servers for enterprise clients requiring maximum performance and security. Manual assignment for custom configurations.',
                'fill_method' => 'manual',
                'is_active' => true,
            ],
            [
                'name' => 'Reseller Hosting - Partners',
                'description' => 'Specialized server group for reseller hosting packages with WHM/cPanel access and white-label capabilities.',
                'fill_method' => 'round_robin',
                'is_active' => true,
            ],
            [
                'name' => 'Development Servers - Testing',
                'description' => 'Development and testing environment servers. Currently inactive for maintenance and upgrades.',
                'fill_method' => 'manual',
                'is_active' => false,
            ],
        ];

        foreach ($serverGroups as $groupData) {
            ServerGroup::create($groupData);
        }

        $this->command->info('Created ' . count($serverGroups) . ' server groups with realistic hosting business data.');
    }
}
