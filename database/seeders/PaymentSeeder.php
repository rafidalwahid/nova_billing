<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some invoices and payment methods
        $invoices = Invoice::with('customer')->take(5)->get();
        $paymentMethods = PaymentMethod::active()->get();

        if ($invoices->isEmpty() || $paymentMethods->isEmpty()) {
            $this->command->warn('No invoices or payment methods found. Please run invoice and payment method seeders first.');
            return;
        }

        $paymentsCreated = 0;
        $transactionsCreated = 0;

        foreach ($invoices as $invoice) {
            // Create 1-3 payments per invoice
            $paymentCount = rand(1, 3);
            $remainingBalance = $invoice->total;

            for ($i = 0; $i < $paymentCount && $remainingBalance > 0; $i++) {
                $paymentMethod = $paymentMethods->random();

                // Calculate payment amount (partial or full)
                if ($i === $paymentCount - 1) {
                    // Last payment covers remaining balance
                    $paymentAmount = $remainingBalance;
                } else {
                    // Partial payment (30-80% of remaining balance)
                    $paymentAmount = $remainingBalance * (rand(30, 80) / 100);
                    $paymentAmount = round($paymentAmount, 2);
                }

                $paymentDate = now()->subDays(rand(1, 30));

                // Create payment
                $payment = Payment::create([
                    'invoice_id' => $invoice->id,
                    'customer_id' => $invoice->customer_id,
                    'payment_method_id' => $paymentMethod->id,
                    'amount' => $paymentAmount,
                    'payment_date' => $paymentDate,
                    'status' => Payment::STATUS_COMPLETED,
                    'gateway_transaction_id' => $this->generateTransactionId($paymentMethod->gateway),
                    'reference_number' => 'REF-' . strtoupper(uniqid()),
                    'notes' => $this->generatePaymentNotes($paymentMethod),
                    'processed_at' => $paymentDate,
                ]);

                // Create corresponding transaction
                $transaction = Transaction::create([
                    'payment_id' => $payment->id,
                    'customer_id' => $invoice->customer_id,
                    'type' => Transaction::TYPE_PAYMENT,
                    'amount' => $paymentAmount,
                    'currency' => 'USD',
                    'gateway_transaction_id' => $payment->gateway_transaction_id,
                    'status' => Transaction::STATUS_COMPLETED,
                    'processed_at' => $paymentDate,
                    'description' => "Payment for Invoice #{$invoice->formatted_invoice_number}",
                    'notes' => $payment->notes,
                ]);

                $remainingBalance -= $paymentAmount;
                $paymentsCreated++;
                $transactionsCreated++;

                // Maybe create a refund for some payments (10% chance)
                if (rand(1, 10) === 1 && $paymentAmount > 50) {
                    $refundAmount = round($paymentAmount * 0.3, 2); // 30% refund

                    $refundTransaction = Transaction::create([
                        'payment_id' => $payment->id,
                        'customer_id' => $invoice->customer_id,
                        'type' => Transaction::TYPE_REFUND,
                        'amount' => $refundAmount,
                        'currency' => 'USD',
                        'status' => Transaction::STATUS_COMPLETED,
                        'processed_at' => $paymentDate->addDays(rand(1, 7)),
                        'description' => "Partial refund for Payment #{$payment->formatted_reference}",
                        'notes' => 'Customer requested partial refund due to service issue',
                    ]);

                    $transactionsCreated++;
                }
            }

            // Update invoice balance and status
            $newBalance = max(0, $invoice->total - $invoice->payments()->sum('amount'));
            $invoice->update([
                'balance_due' => $newBalance,
                'status' => $newBalance <= 0 ? Invoice::STATUS_PAID : $invoice->status,
                'paid_date' => $newBalance <= 0 ? $invoice->payments()->latest()->first()?->payment_date : null,
            ]);
        }

        $this->command->info("Created {$paymentsCreated} payments and {$transactionsCreated} transactions");
    }

    /**
     * Generate a realistic transaction ID based on gateway
     */
    private function generateTransactionId(string $gateway): string
    {
        return match($gateway) {
            'stripe' => 'ch_' . strtolower(str_replace(['+', '/', '='], '', base64_encode(random_bytes(12)))),
            'paypal' => strtoupper(uniqid('PAY-')),
            'bank_transfer' => 'BT' . date('Ymd') . rand(1000, 9999),
            'check' => 'CHK' . rand(100000, 999999),
            default => strtoupper($gateway) . '-' . uniqid(),
        };
    }

    /**
     * Generate payment notes based on payment method
     */
    private function generatePaymentNotes(PaymentMethod $method): string
    {
        $notes = [
            'stripe' => [
                'Payment processed successfully via Stripe',
                'Credit card payment completed',
                'Automatic payment via saved card',
            ],
            'paypal' => [
                'PayPal payment completed',
                'Payment via PayPal account',
                'Express checkout payment',
            ],
            'bank_transfer' => [
                'Bank transfer received and verified',
                'Wire transfer processed',
                'ACH payment completed',
            ],
            'check' => [
                'Check payment received and deposited',
                'Personal check cleared successfully',
                'Business check processed',
            ],
            'manual' => [
                'Manual payment entry by staff',
                'Cash payment received at office',
                'Payment recorded manually',
            ],
        ];

        $gatewayNotes = $notes[$method->gateway] ?? ['Payment processed'];
        return $gatewayNotes[array_rand($gatewayNotes)];
    }
}
