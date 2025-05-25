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
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Payment;
use App\Models\Transaction;

class ProcessRefund extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Process Refund';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $refundsProcessed = 0;

        foreach ($models as $payment) {
            if ($payment instanceof Payment && $payment->status === Payment::STATUS_COMPLETED) {
                $refundAmount = $fields->refund_amount;

                // Validate refund amount
                if ($refundAmount > $payment->amount) {
                    return Action::danger('Refund amount cannot exceed the original payment amount.');
                }

                // Create refund transaction
                $transaction = Transaction::create([
                    'payment_id' => $payment->id,
                    'customer_id' => $payment->customer_id,
                    'type' => Transaction::TYPE_REFUND,
                    'amount' => $refundAmount,
                    'currency' => 'USD',
                    'status' => Transaction::STATUS_COMPLETED,
                    'processed_at' => now(),
                    'description' => "Refund for Payment #{$payment->formatted_reference}",
                    'notes' => $fields->reason,
                ]);

                // Update payment status if full refund
                if ($refundAmount >= $payment->amount) {
                    $payment->update([
                        'status' => Payment::STATUS_REFUNDED,
                    ]);

                    // Update invoice balance
                    $invoice = $payment->invoice;
                    if ($invoice) {
                        $invoice->update([
                            'balance_due' => $invoice->balance_due + $refundAmount,
                            'status' => $invoice->balance_due + $refundAmount > 0 ? 'sent' : $invoice->status,
                        ]);
                    }
                }

                $refundsProcessed++;
            }
        }

        return Action::message("Successfully processed {$refundsProcessed} refund(s)!");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Currency::make('Refund Amount')
                ->currency('USD')
                ->rules('required', 'numeric', 'min:0.01')
                ->help('Amount to refund to customer'),

            Textarea::make('Reason')
                ->rules('required')
                ->help('Reason for the refund'),
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
        return $model instanceof Payment &&
               $model->status === Payment::STATUS_COMPLETED &&
               $request->user()->can('issueRefund', $model);
    }
}
