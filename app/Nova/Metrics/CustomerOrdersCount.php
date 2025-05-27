<?php

namespace App\Nova\Metrics;

use App\Models\Order;
use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;
use Laravel\Nova\Nova;

class CustomerOrdersCount extends Value
{
    /**
     * Calculate the value of the metric.
     */
    public function calculate(NovaRequest $request): ValueResult
    {
        $user = $request->user();

        if (!$user || !$user->isCustomer()) {
            return $this->result(0);
        }

        return $this->count($request, Order::where('customer_id', $user->userable_id));
    }

    /**
     * Get the displayable name of the metric.
     */
    public function name(): string
    {
        return 'Total Orders';
    }

    /**
     * Get the ranges available for the metric.
     */
    public function ranges(): array
    {
        return [
            'ALL' => Nova::__('All Time'),
            365 => Nova::__('365 Days'),
            90 => Nova::__('90 Days'),
            30 => Nova::__('30 Days'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     */
    public function cacheFor(): DateTimeInterface|null
    {
        return now()->addMinutes(5);
    }
}
