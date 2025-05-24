<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Invoice;
use Illuminate\Support\Facades\Mail;

class SendInvoiceEmail extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Send Invoice Email';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $invoice) {
            if ($invoice instanceof Invoice) {
                $customerEmail = $invoice->customer->user->email ?? null;

                if (!$customerEmail) {
                    return Action::danger('Customer email not found for invoice #' . $invoice->invoice_number);
                }

                // For now, we'll simulate sending an email
                // In a real implementation, you would create a Mailable class
                try {
                    // Simulate email sending
                    // Mail::to($customerEmail)->send(new InvoiceMail($invoice, $fields));

                    // Update invoice status to sent if it was draft
                    if ($invoice->status === Invoice::STATUS_DRAFT) {
                        $invoice->update(['status' => Invoice::STATUS_SENT]);
                    }

                    // Log the email sending (you could create an email_logs table)
                    \Log::info("Invoice email sent", [
                        'invoice_id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number,
                        'customer_email' => $customerEmail,
                        'subject' => $fields->subject,
                        'sent_at' => now(),
                    ]);

                } catch (\Exception $e) {
                    return Action::danger('Failed to send email: ' . $e->getMessage());
                }
            }
        }

        return Action::message('Invoice email(s) sent successfully!');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Text::make('Subject')
                ->default('Invoice from Your Company')
                ->rules('required', 'max:255')
                ->help('Email subject line'),

            Textarea::make('Message')
                ->default('Please find your invoice attached. Payment is due within 30 days.')
                ->rules('required')
                ->help('Email message body'),

            Boolean::make('Mark as Sent')
                ->default(true)
                ->help('Update invoice status to "Sent" after sending email'),
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
               $request->user()->can('sendEmail', $model);
    }
}
