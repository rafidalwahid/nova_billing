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
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Invoice;

class MarkAsPaid extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Mark as Paid';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $invoice) {
            if ($invoice instanceof Invoice) {
                $invoice->update([
                    'status' => Invoice::STATUS_PAID,
                    'paid_date' => $fields->paid_date ?? now(),
                    'balance_due' => 0.00,
                ]);
            }
        }

        return Action::message('Invoice(s) marked as paid successfully!');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Date::make('Paid Date')
                ->default(now())
                ->rules('required')
                ->help('The date when the payment was received'),
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
               $model->status !== Invoice::STATUS_PAID &&
               $model->status !== Invoice::STATUS_CANCELLED &&
               $request->user()->can('markAsPaid', $model);
    }
}
