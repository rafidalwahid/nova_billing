<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateRecurringInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:generate-recurring-invoices
                            {--dry-run : Show what would be generated without creating invoices}
                            {--days-ahead=7 : Generate invoices for subscriptions due within X days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate recurring invoices for active subscriptions that are due for billing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting recurring invoice generation...');

        $dryRun = $this->option('dry-run');
        $daysAhead = (int) $this->option('days-ahead');

        if ($dryRun) {
            $this->warn('🧪 DRY RUN MODE - No invoices will be created');
        }

        // Get subscriptions due for billing
        $subscriptionsDue = $this->getSubscriptionsDueForBilling($daysAhead);

        if ($subscriptionsDue->isEmpty()) {
            $this->info('✅ No subscriptions due for billing');
            return 0;
        }

        $this->info("📋 Found {$subscriptionsDue->count()} subscription(s) due for billing");

        $invoicesGenerated = 0;
        $errors = 0;

        foreach ($subscriptionsDue as $subscription) {
            try {
                if ($dryRun) {
                    $this->showDryRunInfo($subscription);
                } else {
                    $invoice = $this->generateInvoiceForSubscription($subscription);
                    if ($invoice) {
                        $invoicesGenerated++;
                        $this->info("✅ Generated invoice #{$invoice->invoice_number} for subscription #{$subscription->subscription_number}");
                    }
                }
            } catch (\Exception $e) {
                $errors++;
                $this->error("❌ Failed to generate invoice for subscription #{$subscription->subscription_number}: {$e->getMessage()}");
                Log::error('Recurring invoice generation failed', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        if (!$dryRun) {
            $this->info("🎉 Successfully generated {$invoicesGenerated} recurring invoice(s)");
            if ($errors > 0) {
                $this->warn("⚠️  {$errors} error(s) occurred during generation");
            }
        }

        return 0;
    }

    /**
     * Get subscriptions that are due for billing
     */
    private function getSubscriptionsDueForBilling(int $daysAhead)
    {
        $cutoffDate = Carbon::now()->addDays($daysAhead);

        return Subscription::with(['customer', 'product', 'productPricing', 'order'])
            ->where('status', Subscription::STATUS_ACTIVE)
            ->where('next_billing_date', '<=', $cutoffDate)
            ->whereDoesntHave('invoices', function ($query) {
                // Don't generate if there's already an unpaid invoice for this subscription
                $query->whereIn('status', [
                    Invoice::STATUS_DRAFT,
                    Invoice::STATUS_SENT,
                    Invoice::STATUS_OVERDUE
                ]);
            })
            ->get();
    }

    /**
     * Generate invoice for a subscription with proper transaction handling
     */
    private function generateInvoiceForSubscription(Subscription $subscription): ?Invoice
    {
        return DB::transaction(function () use ($subscription) {
            // Generate unique invoice number
            $invoiceNumber = $this->generateInvoiceNumber();

            // Calculate invoice dates
            $invoiceDate = Carbon::now();
            $dueDate = $invoiceDate->copy()->addDays(30); // 30 days payment terms

            // Create the invoice
            $invoice = Invoice::create([
                'customer_id' => $subscription->customer_id,
                'subscription_id' => $subscription->id,
                'invoice_number' => $invoiceNumber,
                'status' => Invoice::STATUS_SENT, // Auto-send recurring invoices
                'subtotal' => $subscription->recurring_amount,
                'tax_amount' => 0.00, // TODO: Implement tax calculation
                'total' => $subscription->recurring_amount,
                'balance_due' => $subscription->recurring_amount,
                'currency' => $subscription->currency,
                'invoice_date' => $invoiceDate,
                'due_date' => $dueDate,
                'notes' => "Recurring invoice for {$subscription->product->name} - {$subscription->productPricing->billing_cycle_display}",
                'terms' => 'Payment due within 30 days of invoice date.',
            ]);

            // Create invoice line for the recurring charge
            InvoiceLine::create([
                'invoice_id' => $invoice->id,
                'type' => InvoiceLine::TYPE_PRODUCT,
                'description' => "{$subscription->product->name} - {$subscription->productPricing->billing_cycle_display}",
                'quantity' => 1,
                'unit_price' => $subscription->recurring_amount,
                'total_price' => $subscription->recurring_amount,
            ]);

            // Update subscription billing information
            $subscription->update([
                'next_billing_date' => $subscription->calculateNextBillingDate(),
                'billing_cycles_completed' => $subscription->billing_cycles_completed + 1,
                'last_billing_date' => $invoiceDate,
            ]);

            // Log the invoice generation
            Log::info('Recurring invoice generated', [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'subscription_id' => $subscription->id,
                'customer_id' => $subscription->customer_id,
                'amount' => $subscription->recurring_amount,
            ]);

            return $invoice;
        });
    }

    /**
     * Generate unique invoice number
     */
    private function generateInvoiceNumber(): string
    {
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $nextNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;
        return 'INV-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Show dry run information
     */
    private function showDryRunInfo(Subscription $subscription): void
    {
        $this->line("📄 Would generate invoice for:");
        $this->line("   Subscription: #{$subscription->subscription_number}");
        $this->line("   Customer: {$subscription->customer->full_name}");
        $this->line("   Product: {$subscription->product->name}");
        $this->line("   Amount: {$subscription->currency} {$subscription->recurring_amount}");
        $this->line("   Next Billing: {$subscription->next_billing_date}");
        $this->line("");
    }
}
