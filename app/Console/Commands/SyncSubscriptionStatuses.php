<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\HostingAccount;
use App\Models\DomainRegistration;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SyncSubscriptionStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:sync-subscription-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync subscription statuses with their related services (hosting accounts, domains)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Syncing subscription statuses with services...');

        $hostingUpdates = $this->syncHostingAccountStatuses();
        $domainUpdates = $this->syncDomainStatuses();
        $subscriptionUpdates = $this->updateOverdueSubscriptions();

        $this->info("🏠 Updated {$hostingUpdates} hosting account statuses");
        $this->info("🌐 Updated {$domainUpdates} domain statuses");
        $this->info("💳 Updated {$subscriptionUpdates} overdue subscriptions");

        return 0;
    }

    /**
     * Sync hosting account statuses with subscription statuses
     */
    private function syncHostingAccountStatuses(): int
    {
        $updated = 0;

        // Suspend hosting accounts for suspended subscriptions
        $suspendedCount = HostingAccount::whereHas('subscription', function ($query) {
                $query->where('status', 'suspended');
            })
            ->where('status', 'active')
            ->update([
                'status' => 'suspended',
                'suspended_at' => Carbon::now(),
            ]);

        // Terminate hosting accounts for cancelled subscriptions
        $terminatedCount = HostingAccount::whereHas('subscription', function ($query) {
                $query->where('status', 'cancelled');
            })
            ->whereIn('status', ['active', 'suspended'])
            ->update([
                'status' => 'terminated',
                'terminated_at' => Carbon::now(),
            ]);

        $updated = $suspendedCount + $terminatedCount;

        if ($suspendedCount > 0) {
            $this->line("  → Suspended {$suspendedCount} hosting accounts");
        }
        if ($terminatedCount > 0) {
            $this->line("  → Terminated {$terminatedCount} hosting accounts");
        }

        return $updated;
    }

    /**
     * Sync domain statuses with subscription statuses
     */
    private function syncDomainStatuses(): int
    {
        $updated = 0;

        // Suspend domains for suspended subscriptions (if not already expired)
        $suspendedCount = DomainRegistration::whereHas('subscription', function ($query) {
                $query->where('status', 'suspended');
            })
            ->where('status', 'active')
            ->where('expiration_date', '>', Carbon::now()) // Not expired
            ->update(['status' => 'suspended']);

        // Cancel domains for cancelled subscriptions
        $cancelledCount = DomainRegistration::whereHas('subscription', function ($query) {
                $query->where('status', 'cancelled');
            })
            ->whereIn('status', ['active', 'suspended'])
            ->update(['status' => 'cancelled']);

        $updated = $suspendedCount + $cancelledCount;

        if ($suspendedCount > 0) {
            $this->line("  → Suspended {$suspendedCount} domains");
        }
        if ($cancelledCount > 0) {
            $this->line("  → Cancelled {$cancelledCount} domains");
        }

        return $updated;
    }

    /**
     * Update overdue subscriptions
     */
    private function updateOverdueSubscriptions(): int
    {
        $updated = 0;

        // Suspend subscriptions that are overdue by 7+ days
        $suspendedCount = Subscription::where('status', 'active')
            ->where('next_billing_date', '<', Carbon::now()->subDays(7))
            ->update([
                'status' => 'suspended',
                'suspended_at' => Carbon::now(),
            ]);

        // Cancel subscriptions that are overdue by 30+ days
        $cancelledCount = Subscription::where('status', 'suspended')
            ->where('next_billing_date', '<', Carbon::now()->subDays(30))
            ->update([
                'status' => 'cancelled',
                'cancelled_at' => Carbon::now(),
            ]);

        $updated = $suspendedCount + $cancelledCount;

        if ($suspendedCount > 0) {
            $this->line("  → Suspended {$suspendedCount} overdue subscriptions");
        }
        if ($cancelledCount > 0) {
            $this->line("  → Cancelled {$cancelledCount} long-overdue subscriptions");
        }

        return $updated;
    }
}
