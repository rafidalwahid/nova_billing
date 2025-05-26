<?php

namespace Billing\CustomerPortal;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class CustomerPortal extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     */
    public function boot(): void
    {
        Nova::mix('customer-portal', __DIR__.'/../dist/mix-manifest.json');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     */
    public function menu(Request $request): MenuSection
    {
        return MenuSection::make('Customer Portal', [
            MenuItem::make('Dashboard')
                ->path('/customer-portal/dashboard'),
            MenuItem::make('Orders')
                ->path('/customer-portal/orders'),
            MenuItem::make('Invoices')
                ->path('/customer-portal/invoices'),
            MenuItem::make('Tickets')
                ->path('/customer-portal/tickets'),
            MenuItem::make('Nova')
                ->path('/nova'),
        ])->icon('user')->collapsible();
    }

    /**
     * Determine if the tool should be displayed in the sidebar.
     */
    public function authorize(Request $request): bool
    {
        $user = $request->user();
        return $user && $user->isCustomer();
    }
}
