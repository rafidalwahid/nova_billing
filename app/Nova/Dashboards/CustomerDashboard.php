<?php

namespace App\Nova\Dashboards;

use Illuminate\Http\Request;
use Laravel\Nova\Dashboard;
use App\Nova\Metrics\CustomerOrdersCount;
use App\Nova\Metrics\CustomerActiveServices;
use App\Nova\Metrics\CustomerOrdersTrend;

class CustomerDashboard extends Dashboard
{
    /**
     * Get the displayable name of the dashboard.
     */
    public function label(): string
    {
        return 'Customer Dashboard';
    }

    /**
     * Get the URI key for the dashboard.
     */
    public function uriKey(): string
    {
        return 'customer-dashboard';
    }

    /**
     * Determine if the current user can view the dashboard.
     */
    public static function authorizedToView(Request $request): bool
    {
        $user = $request->user();
        return $user && $user->isCustomer();
    }

    /**
     * Get the cards for the dashboard.
     */
    public function cards(): array
    {
        return [
            new CustomerOrdersCount,
            new CustomerActiveServices,
            new CustomerOrdersTrend,
        ];
    }
}
