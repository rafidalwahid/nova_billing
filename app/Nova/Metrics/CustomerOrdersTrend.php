<?php

namespace App\Nova\Metrics;

use App\Models\Order;
use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\TrendResult;
use Laravel\Nova\Nova;

class CustomerOrdersTrend extends Trend
{
    /**
     * Calculate the value of the metric.
     */
    public function calculate(NovaRequest $request): TrendResult
    {
        $user = $request->user();

        if (!$user || !$user->isCustomer()) {
            return $this->result([]);
        }

        return $this->countByDays($request, Order::where('customer_id', $user->userable_id), 'ordered_at');
    }

    /**
     * Get the displayable name of the metric.
     */
    public function name(): string
    {
        return 'Orders Over Time';
    }

    /**
     * Get the ranges available for the metric.
     */
    public function ranges(): array
    {
        return [
            30 => Nova::__('30 Days'),
            60 => Nova::__('60 Days'),
            90 => Nova::__('90 Days'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     */
    public function cacheFor(): DateTimeInterface|null
    {
        return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     */
    public function uriKey(): string
    {
        return 'customer-orders-trend';
    }
}
