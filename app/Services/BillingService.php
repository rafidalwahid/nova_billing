<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingService
{
    /**
     * Calculate order totals including tax.
     */
    public function calculateOrderTotals(Order $order): array
    {
        $subtotal = $order->items()->sum('total_price');
        $taxAmount = $this->calculateTaxAmount($subtotal);
        $total = $subtotal + $taxAmount;

        return [
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total,
        ];
    }

    /**
     * Calculate tax amount for a given subtotal.
     */
    public function calculateTaxAmount(float $subtotal): float
    {
        // Simple 10% tax rate for now
        // In production, this would be more complex based on location, product type, etc.
        return $subtotal * 0.10;
    }

    /**
     * Calculate next billing date for a subscription.
     */
    public function calculateNextBillingDate(Subscription $subscription, Carbon $fromDate = null): Carbon
    {
        $fromDate = $fromDate ?? Carbon::parse($subscription->next_billing_date ?? $subscription->start_date);

        return match($subscription->billing_cycle) {
            'monthly' => $fromDate->addMonth(),
            'quarterly' => $fromDate->addMonths(3),
            'semi_annually' => $fromDate->addMonths(6),
            'annually' => $fromDate->addYear(),
            default => $fromDate->addMonth(),
        };
    }

    /**
     * Get subscriptions due for billing within specified days.
     */
    public function getSubscriptionsDueForBilling(int $daysAhead = 7): \Illuminate\Database\Eloquent\Collection
    {
        $cutoffDate = now()->addDays($daysAhead)->toDateString();

        return Subscription::active()
            ->where('next_billing_date', '<=', $cutoffDate)
            ->with(['customer', 'product', 'productPricing'])
            ->get();
    }

    /**
     * Generate recurring invoice for a subscription.
     */
    public function generateRecurringInvoice(Subscription $subscription): Invoice
    {
        $invoiceService = app(\App\Services\InvoiceService::class);

        return DB::transaction(function () use ($subscription, $invoiceService) {
            // Generate invoice number using InvoiceService
            $invoiceNumber = $invoiceService->generateInvoiceNumber();

            // Calculate dates
            $invoiceDate = now();
            $dueDate = $invoiceDate->copy()->addDays(30);

            // Calculate tax amount
            $taxAmount = $this->calculateTaxAmount($subscription->recurring_amount);
            $total = $subscription->recurring_amount + $taxAmount;

            // Create the invoice
            $invoice = Invoice::create([
                'customer_id' => $subscription->customer_id,
                'subscription_id' => $subscription->id,
                'invoice_number' => $invoiceNumber,
                'status' => Invoice::STATUS_SENT, // Auto-send recurring invoices
                'subtotal' => $subscription->recurring_amount,
                'tax_amount' => $taxAmount,
                'total' => $total,
                'balance_due' => $total,
                'currency' => $subscription->currency,
                'invoice_date' => $invoiceDate,
                'due_date' => $dueDate,
                'notes' => "Recurring invoice for {$subscription->product->name} - {$subscription->productPricing->billing_cycle_display}",
                'terms' => 'Payment due within 30 days of invoice date.',
            ]);

            // Create invoice line
            InvoiceLine::create([
                'invoice_id' => $invoice->id,
                'type' => InvoiceLine::TYPE_PRODUCT,
                'description' => "{$subscription->product->name} - {$subscription->productPricing->billing_cycle_display}",
                'quantity' => 1,
                'unit_price' => $subscription->recurring_amount,
                'total_price' => $subscription->recurring_amount,
                'billing_cycle' => $subscription->billing_cycle,
            ]);

            // Update subscription billing info
            $this->updateSubscriptionAfterBilling($subscription);

            // Log the generation
            Log::info('Recurring invoice generated', [
                'invoice_id' => $invoice->id,
                'subscription_id' => $subscription->id,
                'amount' => $invoice->total,
            ]);

            return $invoice;
        });
    }

    /**
     * Update subscription after billing.
     */
    protected function updateSubscriptionAfterBilling(Subscription $subscription): void
    {
        $subscription->update([
            'next_billing_date' => $this->calculateNextBillingDate($subscription),
            'billing_cycles_completed' => $subscription->billing_cycles_completed + 1,
            'last_billing_date' => now(),
        ]);
    }

    // Invoice number generation moved to InvoiceService
}
