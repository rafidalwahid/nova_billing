<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Rules\ValidatePaymentAmount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecordPayment extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Record Payment';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $paymentService = app(\App\Services\PaymentService::class);
        $paymentsCreated = 0;
        $errors = [];

        foreach ($models as $invoice) {
            if ($invoice instanceof Invoice) {
                try {
                    // Delegate to service
                    $payment = $paymentService->recordPayment($invoice, [
                        'payment_amount' => $fields->payment_amount,
                        'payment_date' => $fields->payment_date ?? now(),
                        'payment_method' => $fields->payment_method,
                        'notes' => $fields->notes,
                    ]);

                    $paymentsCreated++;

                } catch (\Exception $e) {
                    $errors[] = "Invoice #{$invoice->invoice_number}: " . $e->getMessage();
                }
            }
        }

        if (!empty($errors)) {
            return Action::danger('Some payments failed: ' . implode('; ', $errors));
        }

        return Action::message("Successfully recorded {$paymentsCreated} payment(s)!");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Currency::make('Payment Amount')
                ->currency('USD')
                ->rules('required', 'numeric', 'min:0.01')
                ->help('Amount received from customer'),

            Date::make('Payment Date')
                ->default(now())
                ->rules('required')
                ->help('Date when payment was received'),

            Select::make('Payment Method')
                ->options([
                    'cash' => 'Cash',
                    'check' => 'Check',
                    'credit_card' => 'Credit Card',
                    'bank_transfer' => 'Bank Transfer',
                    'paypal' => 'PayPal',
                    'stripe' => 'Stripe',
                    'other' => 'Other',
                ])
                ->rules('required')
                ->default('credit_card'),

            Textarea::make('Notes')
                ->nullable()
                ->help('Optional payment notes or reference number'),
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
        // Check policy permission and invoice status
        return $model instanceof Invoice &&
               $model->status !== Invoice::STATUS_CANCELLED &&
               $model->balance_due > 0 &&
               $request->user()->can('recordPayment', $model);
    }
}
