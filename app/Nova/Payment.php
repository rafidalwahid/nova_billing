<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Payment as PaymentModel;

class Payment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Payment>
     */
    public static $model = \App\Models\Payment::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'formatted_reference';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Payment Management';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'gateway_transaction_id', 'reference_number',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Reference', 'formatted_reference')
                ->exceptOnForms()
                ->sortable(),

            BelongsTo::make('Invoice')
                ->sortable()
                ->rules('required')
                ->searchable(),

            BelongsTo::make('Customer')
                ->sortable()
                ->rules('required')
                ->searchable()
                ->display(function ($customer) {
                    return $customer->first_name . ' ' . $customer->last_name;
                }),

            BelongsTo::make('Payment Method', 'paymentMethod', PaymentMethod::class)
                ->nullable()
                ->sortable()
                ->searchable(),

            Currency::make('Amount')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0.01')
                ->step(0.01),

            Date::make('Payment Date')
                ->sortable()
                ->rules('required')
                ->default(now()),

            Select::make('Status')
                ->options([
                    PaymentModel::STATUS_PENDING => 'Pending',
                    PaymentModel::STATUS_COMPLETED => 'Completed',
                    PaymentModel::STATUS_FAILED => 'Failed',
                    PaymentModel::STATUS_REFUNDED => 'Refunded',
                    PaymentModel::STATUS_CANCELLED => 'Cancelled',
                ])
                ->displayUsingLabels()
                ->rules('required', 'in:pending,completed,failed,refunded,cancelled')
                ->default(PaymentModel::STATUS_PENDING)
                ->filterable(),

            Text::make('Status', function () {
                $colors = [
                    PaymentModel::STATUS_PENDING => '#f59e0b',
                    PaymentModel::STATUS_COMPLETED => '#10b981',
                    PaymentModel::STATUS_FAILED => '#ef4444',
                    PaymentModel::STATUS_REFUNDED => '#3b82f6',
                    PaymentModel::STATUS_CANCELLED => '#6b7280',
                ];

                $color = $colors[$this->status] ?? '#6b7280';
                $status = $this->status_display;

                return "<span style='display: inline-flex; align-items: center; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; color: white; background: linear-gradient(135deg, {$color}, " . $this->adjustBrightness($color, -20) . ");'>{$status}</span>";
            })
                ->asHtml()
                ->onlyOnIndex(),

            Text::make('Gateway Transaction ID')
                ->nullable()
                ->hideFromIndex()
                ->help('Transaction ID from payment gateway'),

            Text::make('Reference Number')
                ->nullable()
                ->hideFromIndex()
                ->help('Internal reference number'),

            DateTime::make('Processed At')
                ->nullable()
                ->hideFromIndex(),

            Textarea::make('Notes')
                ->nullable()
                ->hideFromIndex(),

            HasMany::make('Transactions'),
        ];
    }

    /**
     * Adjust color brightness
     */
    private function adjustBrightness($hex, $percent) {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $r = max(0, min(255, $r + ($r * $percent / 100)));
        $g = max(0, min(255, $g + ($g * $percent / 100)));
        $b = max(0, min(255, $b + ($b * $percent / 100)));

        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [
            \App\Nova\Actions\ProcessRefund::make(),
        ];
    }
}
