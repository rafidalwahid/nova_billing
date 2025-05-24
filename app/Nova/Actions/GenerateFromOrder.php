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
        $invoicesCreated = 0;

        foreach ($models as $order) {
            if ($order instanceof Order) {
                // Check if invoice already exists for this order
                if ($order->invoice) {
                    continue; // Skip if invoice already exists
                }

                // Generate unique invoice number
                $lastInvoice = Invoice::orderBy('id', 'desc')->first();
                $nextNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;
                $invoiceNumber = 'INV-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

                // Create the invoice
                $invoice = Invoice::create([
                    'customer_id' => $order->customer_id,
                    'order_id' => $order->id,
                    'invoice_number' => $invoiceNumber,
                    'status' => Invoice::STATUS_DRAFT,
                    'subtotal' => $order->subtotal,
                    'tax_amount' => $order->tax_amount,
                    'total' => $order->total,
                    'balance_due' => $order->total,
                    'currency' => $order->currency,
                    'invoice_date' => $fields->invoice_date ?? now(),
                    'due_date' => $fields->due_date ?? now()->addDays($fields->due_days ?? 30),
                    'notes' => $fields->notes ?? "Invoice generated from Order #{$order->order_number}",
                    'terms' => 'Payment due within 30 days of invoice date.',
                ]);

                // Create invoice lines from order items
                foreach ($order->items as $orderItem) {
                    InvoiceLine::create([
                        'invoice_id' => $invoice->id,
                        'order_item_id' => $orderItem->id,
                        'type' => InvoiceLine::TYPE_PRODUCT,
                        'description' => $orderItem->product_name,
                        'quantity' => $orderItem->quantity,
                        'unit_price' => $orderItem->unit_price,
                        'total_price' => $orderItem->total_price,
                        'billing_cycle' => $orderItem->billing_cycle,
                    ]);

                    // Add setup fee as separate line if exists
                    if ($orderItem->setup_fee > 0) {
                        InvoiceLine::create([
                            'invoice_id' => $invoice->id,
                            'order_item_id' => $orderItem->id,
                            'type' => InvoiceLine::TYPE_FEE,
                            'description' => "Setup Fee - {$orderItem->product_name}",
                            'quantity' => 1,
                            'unit_price' => $orderItem->setup_fee,
                            'total_price' => $orderItem->setup_fee,
                        ]);
                    }
                }

                $invoicesCreated++;
            }
        }

        if ($invoicesCreated === 0) {
            return Action::danger('No invoices were created. Orders may already have invoices.');
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
