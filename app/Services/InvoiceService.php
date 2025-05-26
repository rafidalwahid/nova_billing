<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Events\InvoiceGenerated;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceService
{
    /**
     * Generate an invoice from an order.
     */
    public function generateFromOrder(Order $order, array $options = []): Invoice
    {
        // Validate order can have invoice generated
        $this->validateOrderForInvoiceGeneration($order);

        return DB::transaction(function () use ($order, $options) {
            // Create the invoice
            $invoice = $this->createInvoiceFromOrder($order, $options);

            // Create invoice lines from order items
            $this->createInvoiceLinesFromOrderItems($invoice, $order);

            // Validate invoice totals
            $this->validateInvoiceTotals($invoice, $order);

            // Log the generation
            $this->logInvoiceGeneration($invoice, $order);

            // Fire event
            event(new InvoiceGenerated($invoice, $order));

            return $invoice;
        });
    }

    /**
     * Calculate the balance due for an invoice.
     */
    public function calculateBalanceDue(Invoice $invoice): float
    {
        $totalPayments = $invoice->payments()->sum('amount');
        return max(0, $invoice->total - $totalPayments);
    }

    /**
     * Update the balance due for an invoice.
     */
    public function updateBalanceDue(Invoice $invoice): void
    {
        $invoice->balance_due = $this->calculateBalanceDue($invoice);
        $invoice->save();
    }

    /**
     * Mark an invoice as paid.
     */
    public function markAsPaid(Invoice $invoice, Carbon $paidDate = null): void
    {
        $this->validateInvoiceCanBeMarkedPaid($invoice);

        $invoice->update([
            'status' => Invoice::STATUS_PAID,
            'paid_date' => $paidDate ?? now(),
            'balance_due' => 0.00,
        ]);

        Log::info('Invoice marked as paid', [
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
        ]);
    }

    /**
     * Generate a unique invoice number.
     */
    public function generateInvoiceNumber(): string
    {
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $nextNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;
        return 'INV-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Validate that an order can have an invoice generated.
     */
    protected function validateOrderForInvoiceGeneration(Order $order): void
    {
        if ($order->invoice) {
            throw new \InvalidArgumentException('Invoice already exists for this order');
        }

        if ($order->status !== Order::STATUS_ACTIVE) {
            throw new \InvalidArgumentException('Order must be active to generate invoice');
        }

        if ($order->total <= 0) {
            throw new \InvalidArgumentException('Cannot create invoice for order with zero or negative total');
        }
    }

    /**
     * Create the main invoice record from order.
     */
    protected function createInvoiceFromOrder(Order $order, array $options): Invoice
    {
        $invoiceDate = $options['invoice_date'] ?? now();
        $dueDate = $options['due_date'] ?? $this->calculateDueDate($invoiceDate, $options['due_days'] ?? 30);

        return Invoice::create([
            'customer_id' => $order->customer_id,
            'order_id' => $order->id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'status' => Invoice::STATUS_DRAFT,
            'subtotal' => $order->subtotal,
            'tax_amount' => $order->tax_amount,
            'total' => $order->total,
            'balance_due' => $order->total,
            'currency' => $order->currency,
            'invoice_date' => $invoiceDate,
            'due_date' => $dueDate,
            'notes' => $options['notes'] ?? "Invoice generated from Order #{$order->order_number}",
            'terms' => 'Payment due within 30 days of invoice date.',
        ]);
    }

    /**
     * Create invoice lines from order items.
     */
    protected function createInvoiceLinesFromOrderItems(Invoice $invoice, Order $order): void
    {
        foreach ($order->items as $orderItem) {
            // Create main product line
            InvoiceLine::create([
                'invoice_id' => $invoice->id,
                'order_item_id' => $orderItem->id,
                'type' => InvoiceLine::TYPE_PRODUCT,
                'description' => $orderItem->product_name,
                'quantity' => $orderItem->quantity,
                'unit_price' => $orderItem->unit_price,
                'total_price' => $orderItem->total_price,
                'billing_cycle' => $orderItem->billing_cycle,
            ]);

            // Create setup fee line if exists
            if ($orderItem->setup_fee > 0) {
                InvoiceLine::create([
                    'invoice_id' => $invoice->id,
                    'order_item_id' => $orderItem->id,
                    'type' => InvoiceLine::TYPE_FEE,
                    'description' => "Setup Fee - {$orderItem->product_name}",
                    'quantity' => 1,
                    'unit_price' => $orderItem->setup_fee,
                    'total_price' => $orderItem->setup_fee,
                ]);
            }
        }
    }

    /**
     * Validate invoice totals match order totals.
     */
    protected function validateInvoiceTotals(Invoice $invoice, Order $order): void
    {
        $totalLineAmount = $invoice->lines()->sum('total_price');

        if (abs($totalLineAmount - $order->subtotal) > 0.01) {
            throw new \InvalidArgumentException(
                "Invoice line total ({$totalLineAmount}) does not match order subtotal ({$order->subtotal})"
            );
        }
    }

    /**
     * Validate that an invoice can be marked as paid.
     */
    protected function validateInvoiceCanBeMarkedPaid(Invoice $invoice): void
    {
        if ($invoice->status === Invoice::STATUS_PAID) {
            throw new \InvalidArgumentException('Invoice is already paid');
        }

        if ($invoice->status === Invoice::STATUS_CANCELLED) {
            throw new \InvalidArgumentException('Cancelled invoice cannot be marked as paid');
        }
    }

    /**
     * Calculate due date from invoice date and due days.
     */
    protected function calculateDueDate(Carbon $invoiceDate, int $dueDays): Carbon
    {
        return $invoiceDate->copy()->addDays($dueDays);
    }

    /**
     * Log invoice generation.
     */
    protected function logInvoiceGeneration(Invoice $invoice, Order $order): void
    {
        Log::info('Invoice generated from order', [
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'total' => $invoice->total,
        ]);
    }
}
