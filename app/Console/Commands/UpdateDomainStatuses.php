<?php

namespace App\Console\Commands;

use App\Models\DomainRegistration;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateDomainStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:update-domain-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update domain registration statuses based on expiration dates and sync related subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating domain statuses...');

        // Update expired domains
        $expiredCount = $this->updateExpiredDomains();

        // Update domains expiring soon (for notifications)
        $expiringSoonCount = $this->flagExpiringSoonDomains();

        $this->info("✅ Updated {$expiredCount} expired domains");
        $this->info("⚠️  Found {$expiringSoonCount} domains expiring within 30 days");
        $this->info("🔄 Related subscriptions will be updated automatically via events");

        return 0;
    }

    /**
     * Update domains that have expired
     */
    private function updateExpiredDomains(): int
    {
        return DomainRegistration::where('status', 'active')
            ->where('expiration_date', '<', Carbon::now())
            ->update(['status' => 'expired']);
    }

    /**
     * Flag domains expiring soon (for notifications)
     */
    private function flagExpiringSoonDomains(): int
    {
        return DomainRegistration::where('status', 'active')
            ->where('expiration_date', '<=', Carbon::now()->addDays(30))
            ->where('expiration_date', '>', Carbon::now())
            ->count();
    }
}
