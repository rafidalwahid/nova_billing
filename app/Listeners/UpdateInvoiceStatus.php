<?php

namespace App\Listeners;

use App\Events\PaymentProcessed;
use App\Models\Invoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateInvoiceStatus implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(PaymentProcessed $event): void
    {
        $payment = $event->payment;
        $invoice = $event->invoice;

        // Log the payment processing
        Log::info('Payment processed - updating invoice status', [
            'payment_id' => $payment->id,
            'invoice_id' => $invoice->id,
            'amount' => $payment->amount,
            'invoice_balance' => $invoice->balance_due,
        ]);

        // The invoice status and balance should already be updated by PaymentService
        // This listener can handle additional side effects like:
        // - Sending payment confirmation emails
        // - Updating subscription status if invoice is fully paid
        // - Triggering fulfillment processes

        if ($invoice->status === Invoice::STATUS_PAID) {
            Log::info('Invoice fully paid - triggering fulfillment', [
                'invoice_id' => $invoice->id,
                'customer_id' => $invoice->customer_id,
            ]);

            // TODO: Trigger fulfillment processes
            // - Activate services
            // - Send welcome emails
            // - Update subscription status
        }
    }
}
