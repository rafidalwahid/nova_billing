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
        $paymentsCreated = 0;
        $errors = [];

        foreach ($models as $invoice) {
            if ($invoice instanceof Invoice) {
                try {
                    // Validate payment amount against invoice balance
                    $validator = validator(['payment_amount' => $fields->payment_amount], [
                        'payment_amount' => [new ValidatePaymentAmount($invoice)]
                    ]);

                    if ($validator->fails()) {
                        $errors[] = "Invoice #{$invoice->invoice_number}: " . $validator->errors()->first();
                        continue;
                    }

                    // Process payment within transaction
                    DB::transaction(function () use ($fields, $invoice, &$paymentsCreated) {
                        $paymentAmount = $fields->payment_amount;
                        $newBalanceDue = max(0, $invoice->balance_due - $paymentAmount);

                        // Find payment method by name (for backward compatibility)
                        $paymentMethod = null;
                        if ($fields->payment_method) {
                            $paymentMethod = PaymentMethod::where('gateway', $fields->payment_method)
                                ->orWhere('name', 'like', '%' . ucfirst(str_replace('_', ' ', $fields->payment_method)) . '%')
                                ->first();
                        }

                        // Create Payment record
                        $payment = Payment::create([
                            'invoice_id' => $invoice->id,
                            'customer_id' => $invoice->customer_id,
                            'payment_method_id' => $paymentMethod?->id,
                            'amount' => $paymentAmount,
                            'payment_date' => $fields->payment_date ?? now(),
                            'status' => Payment::STATUS_COMPLETED,
                            'reference_number' => 'MAN-' . strtoupper(uniqid()),
                            'notes' => $fields->notes,
                            'processed_at' => now(),
                        ]);

                        // Create Transaction record
                        Transaction::create([
                            'payment_id' => $payment->id,
                            'customer_id' => $invoice->customer_id,
                            'type' => Transaction::TYPE_PAYMENT,
                            'amount' => $paymentAmount,
                            'currency' => 'USD',
                            'status' => Transaction::STATUS_COMPLETED,
                            'processed_at' => now(),
                            'description' => "Payment for Invoice #{$invoice->formatted_invoice_number}",
                            'notes' => $fields->notes,
                        ]);

                        // Update invoice
                        $invoice->update([
                            'balance_due' => $newBalanceDue,
                            'status' => $newBalanceDue <= 0 ? Invoice::STATUS_PAID : $invoice->status,
                            'paid_date' => $newBalanceDue <= 0 ? ($fields->payment_date ?? now()) : $invoice->paid_date,
                        ]);

                        // Log the payment
                        Log::info('Payment recorded', [
                            'payment_id' => $payment->id,
                            'invoice_id' => $invoice->id,
                            'amount' => $paymentAmount,
                            'new_balance' => $newBalanceDue,
                        ]);

                        $paymentsCreated++;
                    });

                } catch (\Exception $e) {
                    $errors[] = "Invoice #{$invoice->invoice_number}: " . $e->getMessage();
                    Log::error('Payment recording failed', [
                        'invoice_id' => $invoice->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        if (!empty($errors)) {
            return Action::danger('Some payments failed: ' . implode('; ', $errors));
        }

        return Action::message("Successfully recorded {$paymentsCreated} payment(s) with proper validation and transaction handling!");
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
