<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class PaymentMethod extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\PaymentMethod>
     */
    public static $model = \App\Models\PaymentMethod::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

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
        'id', 'name', 'gateway',
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

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255')
                ->help('Display name for this payment method'),

            Select::make('Gateway')
                ->options([
                    'manual' => 'Manual',
                    'stripe' => 'Stripe',
                    'paypal' => 'PayPal',
                    'bank_transfer' => 'Bank Transfer',
                    'check' => 'Check',
                    'cash' => 'Cash',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->rules('required')
                ->filterable(),

            Text::make('Gateway', function () {
                $colors = [
                    'manual' => '#6b7280',
                    'stripe' => '#635bff',
                    'paypal' => '#0070ba',
                    'bank_transfer' => '#10b981',
                    'check' => '#f59e0b',
                    'cash' => '#059669',
                ];

                $color = $colors[$this->gateway] ?? '#6b7280';
                $gateway = $this->gateway_display;

                return "<span style='display: inline-flex; align-items: center; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; color: white; background: linear-gradient(135deg, {$color}, " . $this->adjustBrightness($color, -20) . ");'>{$gateway}</span>";
            })
                ->asHtml()
                ->onlyOnIndex(),

            Boolean::make('Active', 'is_active')
                ->sortable()
                ->filterable()
                ->default(true),

            Text::make('Status', function () {
                $color = $this->is_active ? '#10b981' : '#ef4444';
                $status = $this->is_active ? 'Active' : 'Inactive';

                return "<span style='display: inline-flex; align-items: center; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; color: white; background: linear-gradient(135deg, {$color}, " . $this->adjustBrightness($color, -20) . ");'>{$status}</span>";
            })
                ->asHtml()
                ->onlyOnIndex(),

            Number::make('Display Order')
                ->sortable()
                ->rules('required', 'integer', 'min:0')
                ->default(0)
                ->help('Order in which this payment method appears'),

            Textarea::make('Description')
                ->nullable()
                ->hideFromIndex()
                ->help('Optional description for this payment method'),

            Text::make('Icon')
                ->nullable()
                ->hideFromIndex()
                ->help('CSS class or image path for icon'),

            Code::make('Configuration', 'config')
                ->json()
                ->nullable()
                ->hideFromIndex()
                ->help('JSON configuration for payment gateway'),

            HasMany::make('Payments'),
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
