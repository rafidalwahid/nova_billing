<?php

namespace App\Listeners;

use App\Events\DomainStatusChanged;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SyncSubscriptionOnDomainChange implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DomainStatusChanged $event): void
    {
        $domain = $event->domain;
        $subscription = $domain->subscription;

        if (!$subscription) {
            return;
        }

        // Sync subscription status based on domain status change
        match ($event->newStatus) {
            'expired' => $this->handleExpiredDomain($subscription),
            'suspended' => $this->handleSuspendedDomain($subscription),
            'cancelled' => $this->handleCancelledDomain($subscription),
            'active' => $this->handleActiveDomain($subscription),
            default => null,
        };
    }

    /**
     * Handle expired domain
     */
    private function handleExpiredDomain($subscription): void
    {
        if ($subscription->status === 'active') {
            $subscription->update([
                'status' => 'suspended',
                'suspended_at' => Carbon::now(),
            ]);
        }
    }

    /**
     * Handle suspended domain
     */
    private function handleSuspendedDomain($subscription): void
    {
        if ($subscription->status === 'active') {
            $subscription->update([
                'status' => 'suspended',
                'suspended_at' => Carbon::now(),
            ]);
        }
    }

    /**
     * Handle cancelled domain
     */
    private function handleCancelledDomain($subscription): void
    {
        if (in_array($subscription->status, ['active', 'suspended'])) {
            $subscription->update([
                'status' => 'cancelled',
                'cancelled_at' => Carbon::now(),
            ]);
        }
    }

    /**
     * Handle active domain (reactivation)
     */
    private function handleActiveDomain($subscription): void
    {
        if ($subscription->status === 'suspended') {
            $subscription->update([
                'status' => 'active',
                'suspended_at' => null,
            ]);
        }
    }
}
