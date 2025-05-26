<?php

namespace App\Listeners;

use App\Events\InvoiceGenerated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendInvoiceNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(InvoiceGenerated $event): void
    {
        $invoice = $event->invoice;

        // Log the invoice generation
        Log::info('Invoice generated - notification triggered', [
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
            'customer_id' => $invoice->customer_id,
            'total' => $invoice->total,
        ]);

        // TODO: Implement actual email notification
        // This would typically send an email to the customer
        // Mail::to($invoice->customer->email)->send(new InvoiceGeneratedMail($invoice));
    }
}
