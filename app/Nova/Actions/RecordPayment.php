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
        foreach ($models as $invoice) {
            if ($invoice instanceof Invoice) {
                $paymentAmount = $fields->payment_amount;
                $newBalanceDue = max(0, $invoice->balance_due - $paymentAmount);

                $invoice->update([
                    'balance_due' => $newBalanceDue,
                    'status' => $newBalanceDue <= 0 ? Invoice::STATUS_PAID : $invoice->status,
                    'paid_date' => $newBalanceDue <= 0 ? ($fields->payment_date ?? now()) : $invoice->paid_date,
                ]);

                // Here you could also create a Payment record if you have a payments table
                // Payment::create([
                //     'invoice_id' => $invoice->id,
                //     'amount' => $paymentAmount,
                //     'payment_date' => $fields->payment_date,
                //     'payment_method' => $fields->payment_method,
                //     'notes' => $fields->notes,
                // ]);
            }
        }

        return Action::message('Payment(s) recorded successfully!');
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
