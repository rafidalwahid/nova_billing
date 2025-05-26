<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Invoice;

class ValidatePaymentAmount implements ValidationRule
{
    protected $invoice;

    /**
     * Create a new rule instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $paymentAmount = (float) $value;
        $balanceDue = (float) $this->invoice->balance_due;

        // Check if payment amount is positive
        if ($paymentAmount <= 0) {
            $fail('Payment amount must be greater than zero.');
            return;
        }

        // Check if payment amount doesn't exceed balance due
        if ($paymentAmount > $balanceDue) {
            $fail("Payment amount ({$paymentAmount}) cannot exceed the invoice balance due ({$balanceDue}).");
            return;
        }

        // Check if invoice is in a payable status
        if (!in_array($this->invoice->status, [
            Invoice::STATUS_SENT,
            Invoice::STATUS_OVERDUE,
            Invoice::STATUS_DRAFT
        ])) {
            $fail('Payments cannot be recorded for invoices with status: ' . $this->invoice->status);
            return;
        }
    }
}
