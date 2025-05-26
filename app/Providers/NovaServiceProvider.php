<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Features;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Events\ServingNova;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
        Nova::withBreadcrumbs();

        // Set initial path for customers to customer portal
        Nova::initialPath(function (Request $request) {
            $user = $request->user();
            if ($user && $user->isCustomer()) {
                return '/customer-portal/dashboard';
            }
            return '/dashboards/main';
        });

        // Register Nova resources
        Nova::resources([
            // \App\Nova\User::class, // Hidden - managed through Customer/AdminUser
            \App\Nova\Customer::class,
            \App\Nova\AdminUser::class,
            \App\Nova\Role::class,
            \App\Nova\Permission::class,
            \App\Nova\Department::class,
            \App\Nova\Product::class,
            \App\Nova\ProductPricing::class,
            \App\Nova\ProductFeature::class,
            \App\Nova\ServerGroup::class,
            \App\Nova\Server::class,
            \App\Nova\HostingAccount::class,
            \App\Nova\DomainRegistration::class,
            \App\Nova\Order::class,
            \App\Nova\OrderItem::class,
            \App\Nova\Invoice::class,
            \App\Nova\InvoiceLine::class,
            \App\Nova\Payment::class,
            \App\Nova\PaymentMethod::class,
            \App\Nova\Transaction::class,
            \App\Nova\Subscription::class,
            \App\Nova\SubscriptionItem::class,
            \App\Nova\Ticket::class,
            \App\Nova\TicketResponse::class,
        ]);

        // Configure custom navigation
        Nova::mainMenu(function (Request $request) {
            $user = $request->user();

            // If user is a customer, show minimal menu
            if ($user && $user->isCustomer()) {
                return [
                    // Customers see main dashboard but will use Customer Portal tool for functionality
                    \Laravel\Nova\Menu\MenuSection::dashboard(\App\Nova\Dashboards\Main::class)->icon('chart-bar'),
                ];
            }

            // Staff users see full admin menu
            return [
                \Laravel\Nova\Menu\MenuSection::dashboard(\App\Nova\Dashboards\Main::class)->icon('chart-bar'),

                \Laravel\Nova\Menu\MenuSection::make('Customer Management', [
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\Customer::class),
                ])->icon('users')->collapsible(),

                \Laravel\Nova\Menu\MenuSection::make('Product Catalog', [
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\Product::class),
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\ProductFeature::class),
                ])->icon('cube')->collapsible(),

                \Laravel\Nova\Menu\MenuSection::make('Infrastructure Management', [
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\ServerGroup::class),
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\Server::class),
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\HostingAccount::class),
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\DomainRegistration::class),
                ])->icon('server')->collapsible(),

                \Laravel\Nova\Menu\MenuSection::make('Order Management', [
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\Order::class),
                ])->icon('shopping-cart')->collapsible(),

                \Laravel\Nova\Menu\MenuSection::make('Invoice Management', [
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\Invoice::class),
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\InvoiceLine::class),
                ])->icon('document-text')->collapsible(),

                \Laravel\Nova\Menu\MenuSection::make('Payment Management', [
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\Payment::class),
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\PaymentMethod::class),
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\Transaction::class),
                ])->icon('credit-card')->collapsible(),

                \Laravel\Nova\Menu\MenuSection::make('Subscription Management', [
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\Subscription::class),
                ])->icon('refresh')->collapsible(),

                \Laravel\Nova\Menu\MenuSection::make('Staff Management', [
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\AdminUser::class),
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\Role::class),
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\Permission::class),
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\Department::class),
                ])->icon('user-group')->collapsible(),

                \Laravel\Nova\Menu\MenuSection::make('Support Management', [
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\Ticket::class),
                    \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\TicketResponse::class),
                ])->icon('support')->collapsible(),
            ];
        });
    }

    /**
     * Register the configurations for Laravel Fortify.
     */
    protected function fortify(): void
    {
        Nova::fortify()
            ->features([
                Features::updatePasswords(),
                // Features::emailVerification(),
                // Features::twoFactorAuthentication(['confirm' => true, 'confirmPassword' => true]),
            ])
            ->register();
    }

    /**
     * Register the Nova routes.
     */
    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes(default: true)
            ->withPasswordResetRoutes()
            ->withoutEmailVerificationRoutes()
            ->register();
    }



    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array<int, \Laravel\Nova\Dashboard>
     */
    protected function dashboards(): array
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array<int, \Laravel\Nova\Tool>
     */
    public function tools(): array
    {
        $tools = [];

        // Always add customer portal - it will handle its own authorization
        $tools[] = new \Billing\CustomerPortal\CustomerPortal;

        return $tools;
    }



    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();

        //
    }
}
