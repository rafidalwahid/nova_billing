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

        // Set initial path for customers to customer dashboard
        Nova::initialPath(function (Request $request) {
            $user = $request->user();
            if ($user && $user->isCustomer()) {
                return '/dashboards/customer-dashboard';
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
            \App\Nova\CustomerOrder::class, // Customer-facing order resource
            \App\Nova\CustomerOrderItem::class, // Customer-facing order item resource
            \App\Nova\Invoice::class,
            \App\Nova\InvoiceLine::class,
            \App\Nova\CustomerInvoice::class, // Customer-facing invoice resource
            \App\Nova\CustomerInvoiceLine::class, // Customer-facing invoice line resource
            \App\Nova\Payment::class,
            \App\Nova\PaymentMethod::class,
            \App\Nova\CustomerPayment::class, // Customer-facing payment resource
            \App\Nova\Transaction::class,
            \App\Nova\Subscription::class,
            \App\Nova\SubscriptionItem::class,
            \App\Nova\CustomerSubscriptionItem::class, // Customer-facing subscription item resource
            \App\Nova\Ticket::class,
            \App\Nova\TicketResponse::class,
        ]);

        // Configure custom navigation
        Nova::mainMenu(function (Request $request) {
            $user = $request->user();

            // If user is a customer, show customer portal menu
            if ($user && $user->isCustomer()) {
                return [
                    \Laravel\Nova\Menu\MenuSection::dashboard(\App\Nova\Dashboards\CustomerDashboard::class)->icon('chart-bar'),

                    \Laravel\Nova\Menu\MenuSection::make('My Account', [
                        \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\CustomerOrder::class),
                        \Laravel\Nova\Menu\MenuItem::resource(\App\Nova\CustomerInvoice::class),
                    ])->icon('user-circle')->collapsible(),

                    \Laravel\Nova\Menu\MenuSection::make('Support', [
                        \Laravel\Nova\Menu\MenuItem::externalLink('Customer Support', '/nova/customer-support'),
                    ])->icon('support')->collapsible(),
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
     */
    protected function dashboards(): array
    {
        return [
            new \App\Nova\Dashboards\Main,
            new \App\Nova\Dashboards\CustomerDashboard,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     */
    public function tools(): array
    {
        \Log::info('NovaServiceProvider tools() method called');

        $tools = [
            new \Billing\CustomerSupport\CustomerSupport,
        ];

        \Log::info('Tools registered', ['count' => count($tools)]);

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
