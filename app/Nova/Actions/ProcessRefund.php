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
        $paymentService = app(\App\Services\PaymentService::class);
        $refundsProcessed = 0;
        $errors = [];

        foreach ($models as $payment) {
            if ($payment instanceof Payment && $payment->status === Payment::STATUS_COMPLETED) {
                try {
                    // Delegate to service
                    $paymentService->processRefund(
                        $payment,
                        $fields->refund_amount,
                        $fields->reason
                    );
                    $refundsProcessed++;
                } catch (\Exception $e) {
                    $errors[] = "Payment #{$payment->reference}: " . $e->getMessage();
                }
            }
        }

        if (!empty($errors)) {
            return Action::danger('Some refunds failed: ' . implode('; ', $errors));
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
