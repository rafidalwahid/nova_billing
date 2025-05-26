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

        // Get subscriptions due for billing using service
        $billingService = app(\App\Services\BillingService::class);
        $subscriptionsDue = $billingService->getSubscriptionsDueForBilling($daysAhead);

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
                    $invoice = $billingService->generateRecurringInvoice($subscription);
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

    // Business logic methods moved to BillingService

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
