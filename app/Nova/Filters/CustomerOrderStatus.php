<?php

namespace App\Nova\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class CustomerOrderStatus extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Order Status';

    /**
     * Apply the filter to the given query.
     */
    public function apply(NovaRequest $request, Builder $query, mixed $value): Builder
    {
        return $query->where('status', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @return array<string, string>
     */
    public function options(NovaRequest $request): array
    {
        return [
            'Active' => \App\Models\Order::STATUS_ACTIVE,
            'Processing' => \App\Models\Order::STATUS_PROCESSING,
            'Pending' => \App\Models\Order::STATUS_PENDING,
            'Cancelled' => \App\Models\Order::STATUS_CANCELLED,
        ];
    }
}
