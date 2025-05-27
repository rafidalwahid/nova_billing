<?php

namespace App\Nova\Metrics;

use App\Models\Subscription;
use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class CustomerActiveServices extends Value
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

        return $this->count($request, Subscription::where('customer_id', $user->userable_id)->where('status', 'active'));
    }

    /**
     * Get the displayable name of the metric.
     */
    public function name(): string
    {
        return 'Active Services';
    }

    /**
     * Get the ranges available for the metric.
     */
    public function ranges(): array
    {
        return [
            'ALL' => __('All Time'),
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
