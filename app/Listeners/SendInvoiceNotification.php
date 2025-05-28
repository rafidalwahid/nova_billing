<?php

namespace App\Listeners;

use App\Events\InvoiceGenerated;
use App\Mail\InvoiceGenerated as InvoiceGeneratedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendInvoiceNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(InvoiceGenerated $event): void
    {
        try {
            $invoice = $event->invoice;

            // Check if invoice notifications are enabled
            if (!config('billing.notifications.invoice_generated', true)) {
                return;
            }

            // Log the invoice generation
            Log::info('Invoice generated - notification triggered', [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'customer_id' => $invoice->customer_id,
                'total' => $invoice->total,
            ]);

            // Send email to customer
            Mail::to($invoice->customer->email)
                ->send(new InvoiceGeneratedMail($invoice));

            Log::info('Invoice notification sent successfully', [
                'invoice_id' => $invoice->id,
                'customer_email' => $invoice->customer->email,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send invoice notification', [
                'invoice_id' => $event->invoice->id,
                'error' => $e->getMessage(),
            ]);

            // Re-throw to trigger retry mechanism
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(InvoiceGenerated $event, \Throwable $exception): void
    {
        Log::error('Invoice notification failed permanently', [
            'invoice_id' => $event->invoice->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
