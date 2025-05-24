<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Policies\InvoicePolicy;
use App\Policies\InvoiceLinePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Invoice::class => InvoicePolicy::class,
        InvoiceLine::class => InvoiceLinePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Additional gates can be defined here if needed
    }
}
