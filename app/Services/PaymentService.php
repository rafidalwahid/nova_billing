<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Events\PaymentProcessed;
use App\Rules\ValidatePaymentAmount;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Record a payment for an invoice.
     */
    public function recordPayment(Invoice $invoice, array $paymentData): Payment
    {
        // Validate payment data
        $this->validatePaymentData($invoice, $paymentData);

        return DB::transaction(function () use ($invoice, $paymentData) {
            // Create the payment record
            $payment = $this->createPaymentRecord($invoice, $paymentData);

            // Create transaction record
            $this->createTransactionRecord($payment, $paymentData);

            // Update invoice balance
            $this->updateInvoiceBalance($invoice);

            // Update invoice status if fully paid
            $this->updateInvoiceStatusIfPaid($invoice);

            // Log the payment
            $this->logPaymentProcessed($payment);

            // Fire event
            event(new PaymentProcessed($payment, $invoice));

            return $payment;
        });
    }

    /**
     * Generate a unique payment reference.
     */
    public function generatePaymentReference(): string
    {
        $lastPayment = Payment::orderBy('id', 'desc')->first();
        $nextNumber = $lastPayment ? $lastPayment->id + 1 : 1;
        return 'PAY-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Process a refund for a payment.
     */
    public function processRefund(Payment $payment, float $refundAmount, string $reason = null): Payment
    {
        $this->validateRefundRequest($payment, $refundAmount);

        return DB::transaction(function () use ($payment, $refundAmount, $reason) {
            // Create refund payment record
            $refund = Payment::create([
                'invoice_id' => $payment->invoice_id,
                'customer_id' => $payment->customer_id,
                'payment_method_id' => $payment->payment_method_id,
                'reference_number' => $this->generatePaymentReference(),
                'amount' => -$refundAmount, // Negative amount for refund
                'currency' => $payment->currency,
                'payment_date' => now(),
                'status' => Payment::STATUS_COMPLETED,
                'notes' => $reason ? "Refund: {$reason}" : 'Payment refund',
            ]);

            // Update original invoice balance
            $this->updateInvoiceBalance($payment->invoice);

            // Log the refund
            Log::info('Payment refund processed', [
                'refund_payment_id' => $refund->id,
                'original_payment_id' => $payment->id,
                'refund_amount' => $refundAmount,
                'reason' => $reason,
            ]);

            return $refund;
        });
    }

    /**
     * Validate payment data against business rules.
     */
    protected function validatePaymentData(Invoice $invoice, array $paymentData): void
    {
        $validator = validator($paymentData, [
            'payment_amount' => [
                'required',
                'numeric',
                'min:0.01',
                new ValidatePaymentAmount($invoice)
            ],
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }
    }

    /**
     * Create the payment record.
     */
    protected function createPaymentRecord(Invoice $invoice, array $paymentData): Payment
    {
        return Payment::create([
            'invoice_id' => $invoice->id,
            'customer_id' => $invoice->customer_id,
            'payment_method_id' => $this->getOrCreatePaymentMethod($paymentData['payment_method']),
            'reference_number' => $this->generatePaymentReference(),
            'amount' => $paymentData['payment_amount'],
            'currency' => $invoice->currency,
            'payment_date' => $paymentData['payment_date'],
            'status' => Payment::STATUS_COMPLETED,
            'notes' => $paymentData['notes'] ?? null,
        ]);
    }

    /**
     * Create transaction record for the payment.
     */
    protected function createTransactionRecord(Payment $payment, array $paymentData): Transaction
    {
        return Transaction::create([
            'payment_id' => $payment->id,
            'customer_id' => $payment->customer_id,
            'type' => Transaction::TYPE_PAYMENT,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'status' => Transaction::STATUS_COMPLETED,
            'gateway_reference' => $payment->reference_number,
            'processed_at' => $payment->payment_date,
            'description' => "Payment for Invoice #{$payment->invoice->invoice_number}",
        ]);
    }

    /**
     * Update invoice balance after payment.
     */
    protected function updateInvoiceBalance(Invoice $invoice): void
    {
        $totalPayments = $invoice->payments()->sum('amount');
        $invoice->balance_due = max(0, $invoice->total - $totalPayments);
        $invoice->save();
    }

    /**
     * Update invoice status if fully paid.
     */
    protected function updateInvoiceStatusIfPaid(Invoice $invoice): void
    {
        if ($invoice->balance_due <= 0.01) { // Allow for small rounding differences
            $invoice->update([
                'status' => Invoice::STATUS_PAID,
                'paid_date' => now(),
            ]);
        }
    }

    /**
     * Get or create payment method.
     */
    protected function getOrCreatePaymentMethod(string $methodType): ?int
    {
        // For now, return null - payment method is optional
        // In future, this could create/find payment method records
        return null;
    }

    /**
     * Validate refund request.
     */
    protected function validateRefundRequest(Payment $payment, float $refundAmount): void
    {
        if ($payment->amount <= 0) {
            throw new \InvalidArgumentException('Cannot refund a negative payment');
        }

        if ($refundAmount > $payment->amount) {
            throw new \InvalidArgumentException('Refund amount cannot exceed original payment amount');
        }

        if ($refundAmount <= 0) {
            throw new \InvalidArgumentException('Refund amount must be positive');
        }
    }

    /**
     * Log payment processing.
     */
    protected function logPaymentProcessed(Payment $payment): void
    {
        Log::info('Payment processed successfully', [
            'payment_id' => $payment->id,
            'payment_reference' => $payment->reference_number,
            'invoice_id' => $payment->invoice_id,
            'amount' => $payment->amount,
            'customer_id' => $payment->customer_id,
        ]);
    }
}
