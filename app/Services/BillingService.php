<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Order;
use App\Exceptions\BillingException;
use App\Exceptions\InvoiceGenerationException;
use App\Exceptions\TaxCalculationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingService
{
    protected TaxCalculationService $taxService;

    public function __construct(TaxCalculationService $taxService)
    {
        $this->taxService = $taxService;
    }
    /**
     * Calculate order totals including tax.
     */
    public function calculateOrderTotals(Order $order): array
    {
        try {
            $subtotal = $order->items()->sum('total_price');

            if ($subtotal <= 0) {
                throw new BillingException('Order subtotal must be greater than zero', 'INVALID_ORDER_TOTAL', [
                    'order_id' => $order->id,
                    'subtotal' => $subtotal,
                ]);
            }

            // Use the new tax calculation service
            $customer = $order->customer;
            if (!$customer) {
                throw new BillingException('Order must have a customer', 'MISSING_CUSTOMER', [
                    'order_id' => $order->id,
                ]);
            }

            $taxCalculation = $this->taxService->calculateTax($customer, $subtotal);

            $total = $subtotal + $taxCalculation['tax_amount'];

            return [
                'subtotal' => $subtotal,
                'tax_amount' => $taxCalculation['tax_amount'],
                'tax_rate' => $taxCalculation['tax_rate'],
                'tax_description' => $taxCalculation['tax_description'],
                'tax_jurisdiction' => $taxCalculation['tax_jurisdiction'],
                'total' => $total,
            ];
        } catch (TaxCalculationException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new BillingException('Failed to calculate order totals: ' . $e->getMessage(), 'ORDER_CALCULATION_FAILED', [
                'order_id' => $order->id,
                'original_error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Calculate tax amount for a given subtotal and customer.
     * @deprecated Use TaxCalculationService directly instead
     */
    public function calculateTaxAmount(float $subtotal, $customer = null): float
    {
        if ($customer) {
            $taxCalculation = $this->taxService->calculateTax($customer, $subtotal);
            return $taxCalculation['tax_amount'];
        }

        // Fallback for backward compatibility
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
