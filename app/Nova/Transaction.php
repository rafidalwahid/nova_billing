<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Transaction as TransactionModel;

class Transaction extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Transaction>
     */
    public static $model = \App\Models\Transaction::class;

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
        'id', 'gateway_transaction_id', 'gateway_reference', 'description',
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

            BelongsTo::make('Payment')
                ->sortable()
                ->rules('required')
                ->searchable(),

            BelongsTo::make('Customer')
                ->sortable()
                ->rules('required')
                ->searchable(),

            Select::make('Type')
                ->options([
                    TransactionModel::TYPE_PAYMENT => 'Payment',
                    TransactionModel::TYPE_REFUND => 'Refund',
                    TransactionModel::TYPE_CHARGEBACK => 'Chargeback',
                    TransactionModel::TYPE_FEE => 'Fee',
                    TransactionModel::TYPE_ADJUSTMENT => 'Adjustment',
                ])
                ->displayUsingLabels()
                ->rules('required', 'in:payment,refund,chargeback,fee,adjustment')
                ->default(TransactionModel::TYPE_PAYMENT)
                ->filterable(),

            Text::make('Type', function () {
                $colors = [
                    TransactionModel::TYPE_PAYMENT => '#10b981',
                    TransactionModel::TYPE_REFUND => '#3b82f6',
                    TransactionModel::TYPE_CHARGEBACK => '#ef4444',
                    TransactionModel::TYPE_FEE => '#f59e0b',
                    TransactionModel::TYPE_ADJUSTMENT => '#6b7280',
                ];

                $color = $colors[$this->type] ?? '#6b7280';
                $type = $this->type_display;

                return "<span style='display: inline-flex; align-items: center; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; color: white; background: linear-gradient(135deg, {$color}, " . $this->adjustBrightness($color, -20) . ");'>{$type}</span>";
            })
                ->asHtml()
                ->onlyOnIndex(),

            Currency::make('Amount')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric')
                ->step(0.01),

            Text::make('Currency')
                ->default('USD')
                ->rules('required', 'size:3')
                ->hideFromIndex(),

            Select::make('Status')
                ->options([
                    TransactionModel::STATUS_PENDING => 'Pending',
                    TransactionModel::STATUS_COMPLETED => 'Completed',
                    TransactionModel::STATUS_FAILED => 'Failed',
                    TransactionModel::STATUS_CANCELLED => 'Cancelled',
                ])
                ->displayUsingLabels()
                ->rules('required', 'in:pending,completed,failed,cancelled')
                ->default(TransactionModel::STATUS_PENDING)
                ->filterable(),

            Text::make('Status', function () {
                $colors = [
                    TransactionModel::STATUS_PENDING => '#f59e0b',
                    TransactionModel::STATUS_COMPLETED => '#10b981',
                    TransactionModel::STATUS_FAILED => '#ef4444',
                    TransactionModel::STATUS_CANCELLED => '#6b7280',
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

            Text::make('Gateway Reference')
                ->nullable()
                ->hideFromIndex()
                ->help('Reference from payment gateway'),

            DateTime::make('Processed At')
                ->nullable()
                ->hideFromIndex(),

            Text::make('Description')
                ->nullable()
                ->hideFromIndex()
                ->help('Transaction description'),

            Textarea::make('Notes')
                ->nullable()
                ->hideFromIndex(),
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
        return [];
    }
}
