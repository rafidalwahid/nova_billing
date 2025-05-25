<?php

namespace App\Listeners;

use App\Events\SubscriptionStatusChanged;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CascadeSubscriptionStatusToServices implements ShouldQueue
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
    public function handle(SubscriptionStatusChanged $event): void
    {
        $subscription = $event->subscription;

        // Cascade status changes to related services
        match ($event->newStatus) {
            'suspended' => $this->suspendServices($subscription),
            'cancelled' => $this->cancelServices($subscription),
            'active' => $this->reactivateServices($subscription, $event->oldStatus),
            default => null,
        };
    }

    /**
     * Suspend all services for a subscription
     */
    private function suspendServices($subscription): void
    {
        $now = Carbon::now();

        // Suspend hosting accounts
        $subscription->hostingAccounts()
            ->where('status', 'active')
            ->update([
                'status' => 'suspended',
                'suspension_reason' => 'payment',
                'suspended_at' => $now,
            ]);

        // Suspend domains (if not already expired)
        $subscription->domainRegistrations()
            ->where('status', 'active')
            ->where('expiration_date', '>', $now) // Don't suspend already expired domains
            ->update(['status' => 'suspended']);
    }

    /**
     * Cancel/terminate all services for a subscription
     */
    private function cancelServices($subscription): void
    {
        $now = Carbon::now();

        // Terminate hosting accounts
        $subscription->hostingAccounts()
            ->whereIn('status', ['active', 'suspended'])
            ->update([
                'status' => 'terminated',
                'terminated_at' => $now,
            ]);

        // Cancel domains
        $subscription->domainRegistrations()
            ->whereIn('status', ['active', 'suspended'])
            ->update(['status' => 'cancelled']);
    }

    /**
     * Reactivate services when subscription becomes active again
     */
    private function reactivateServices($subscription, $oldStatus): void
    {
        // Only reactivate if coming from suspended state
        if ($oldStatus !== 'suspended') {
            return;
        }

        // Reactivate hosting accounts
        $subscription->hostingAccounts()
            ->where('status', 'suspended')
            ->where('suspension_reason', 'payment') // Only payment suspensions
            ->update([
                'status' => 'active',
                'suspension_reason' => null,
                'suspended_at' => null,
            ]);

        // Reactivate domains (if not expired)
        $subscription->domainRegistrations()
            ->where('status', 'suspended')
            ->where('expiration_date', '>', Carbon::now()) // Don't reactivate expired domains
            ->update(['status' => 'active']);
    }
}
