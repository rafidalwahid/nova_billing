<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\DomainStatusChanged;
use App\Events\SubscriptionStatusChanged;
use App\Listeners\SyncSubscriptionOnDomainChange;
use App\Listeners\CascadeSubscriptionStatusToServices;
use App\Models\Order;
use App\Observers\OrderObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers
        Order::observe(OrderObserver::class);

        // Register event listeners
        Event::listen(
            DomainStatusChanged::class,
            SyncSubscriptionOnDomainChange::class,
        );

        Event::listen(
            SubscriptionStatusChanged::class,
            CascadeSubscriptionStatusToServices::class,
        );
    }
}
