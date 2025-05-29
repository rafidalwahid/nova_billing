<?php

namespace App\Nova\Metrics;

use App\Models\Customer;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class ActiveCustomers extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Laravel\Nova\Metrics\ValueResult
     */
    public function calculate(NovaRequest $request): ValueResult
    {
        $range = $request->range ?? 30;
        
        return $this->count($request, Customer::active())
            ->previous($this->count($request, Customer::active()->where('created_at', '<', now()->subDays($range))));
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges(): array
    {
        return [
            7 => __('7 Days'),
            30 => __('30 Days'),
            60 => __('60 Days'),
            90 => __('90 Days'),
            365 => __('1 Year'),
            'ALL' => __('All Time'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|null
     */
    public function cacheFor(): ?\DateTimeInterface
    {
        return now()->addMinutes(15);
    }

    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Active Customers';
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey(): string
    {
        return 'active-customers';
    }
}
