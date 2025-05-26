<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateFromOrder extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Generate Invoice';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $invoiceService = app(\App\Services\InvoiceService::class);
        $invoicesCreated = 0;
        $errors = [];

        foreach ($models as $order) {
            if ($order instanceof Order) {
                try {
                    // Skip if invoice already exists
                    if ($order->invoice) {
                        continue;
                    }

                    // Delegate to service
                    $invoice = $invoiceService->generateFromOrder($order, [
                        'invoice_date' => $fields->invoice_date,
                        'due_date' => $fields->due_date,
                        'due_days' => $fields->due_days,
                        'notes' => $fields->notes,
                    ]);

                    $invoicesCreated++;

                } catch (\Exception $e) {
                    $errors[] = "Order #{$order->order_number}: " . $e->getMessage();
                }
            }
        }

        if ($invoicesCreated === 0 && empty($errors)) {
            return Action::danger('No invoices were created. Orders may already have invoices.');
        }

        if (!empty($errors)) {
            return Action::danger('Some invoices failed to generate: ' . implode('; ', $errors));
        }

        return Action::message("Successfully created {$invoicesCreated} invoice(s) from selected order(s)!");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Date::make('Invoice Date')
                ->default(now())
                ->rules('required')
                ->help('Date to appear on the invoice'),

            Number::make('Due Days')
                ->default(30)
                ->rules('required', 'integer', 'min:1', 'max:365')
                ->help('Number of days from invoice date until payment is due'),

            Date::make('Due Date')
                ->nullable()
                ->help('Specific due date (overrides Due Days if provided)'),

            Textarea::make('Notes')
                ->nullable()
                ->help('Additional notes to include on the invoice'),
        ];
    }

    /**
     * Determine if the action is executable for the given request.
     */
    public function authorizedToSee(\Illuminate\Http\Request $request)
    {
        return true;
    }

    /**
     * Determine if the action is executable for the given request.
     */
    public function authorizedToRun(\Illuminate\Http\Request $request, $model)
    {
        // Check policy permission and order status
        return $model instanceof Order &&
               $model->status === Order::STATUS_ACTIVE &&
               !$model->invoice &&
               $request->user()->can('create', \App\Models\Invoice::class);
    }
}
