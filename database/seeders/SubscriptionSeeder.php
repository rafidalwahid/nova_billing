<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\SubscriptionItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductPricing;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data
        $customers = Customer::all();
        $hostingProducts = Product::where('type', 'hosting')->with('pricing')->get();
        $orders = Order::all();

        if ($customers->isEmpty() || $hostingProducts->isEmpty()) {
            $this->command->warn('No customers or hosting products found. Please run CustomerSeeder and ProductSeeder first.');
            return;
        }

        $subscriptions = [
            [
                'customer_id' => $customers->random()->id,
                'product' => $hostingProducts->random(),
                'status' => Subscription::STATUS_ACTIVE,
                'billing_cycle' => 'monthly',
                'start_date' => Carbon::now()->subMonths(3),
                'billing_cycles_completed' => 3,
                'notes' => 'Premium hosting subscription with excellent uptime',
            ],
            [
                'customer_id' => $customers->random()->id,
                'product' => $hostingProducts->random(),
                'status' => Subscription::STATUS_ACTIVE,
                'billing_cycle' => 'annually',
                'start_date' => Carbon::now()->subMonths(6),
                'billing_cycles_completed' => 0,
                'notes' => 'Annual hosting plan with significant savings',
            ],
            [
                'customer_id' => $customers->random()->id,
                'product' => $hostingProducts->random(),
                'status' => Subscription::STATUS_SUSPENDED,
                'billing_cycle' => 'monthly',
                'start_date' => Carbon::now()->subMonths(2),
                'billing_cycles_completed' => 2,
                'failed_payment_attempts' => 3,
                'suspended_at' => Carbon::now()->subDays(5),
                'notes' => 'Suspended due to failed payment attempts',
            ],
            [
                'customer_id' => $customers->random()->id,
                'product' => $hostingProducts->random(),
                'status' => Subscription::STATUS_ACTIVE,
                'billing_cycle' => 'quarterly',
                'start_date' => Carbon::now()->subMonths(1),
                'billing_cycles_completed' => 0,
                'notes' => 'New quarterly subscription for growing business',
            ],
            [
                'customer_id' => $customers->random()->id,
                'product' => $hostingProducts->random(),
                'status' => Subscription::STATUS_CANCELLED,
                'billing_cycle' => 'monthly',
                'start_date' => Carbon::now()->subMonths(8),
                'billing_cycles_completed' => 7,
                'cancelled_at' => Carbon::now()->subMonth(),
                'end_date' => Carbon::now()->subMonth(),
                'notes' => 'Customer cancelled due to business closure',
            ],
            [
                'customer_id' => $customers->random()->id,
                'product' => $hostingProducts->random(),
                'status' => Subscription::STATUS_ACTIVE,
                'billing_cycle' => 'semi_annually',
                'start_date' => Carbon::now()->subMonths(4),
                'billing_cycles_completed' => 0,
                'notes' => 'Semi-annual subscription with custom configuration',
            ],
        ];

        foreach ($subscriptions as $index => $subscriptionData) {
            $product = $subscriptionData['product'];
            $pricing = $product->pricing->where('billing_cycle', $subscriptionData['billing_cycle'])->first();

            if (!$pricing) {
                $this->command->warn("No pricing found for {$product->name} with {$subscriptionData['billing_cycle']} billing cycle");
                continue;
            }

            // Generate unique subscription number
            $subscriptionNumber = 'SUB-' . str_pad($index + 1, 6, '0', STR_PAD_LEFT);

            // Calculate next billing date
            $nextBillingDate = $this->calculateNextBillingDate(
                $subscriptionData['start_date'],
                $subscriptionData['billing_cycle'],
                $subscriptionData['billing_cycles_completed']
            );

            // Create subscription
            $subscription = Subscription::create([
                'customer_id' => $subscriptionData['customer_id'],
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'product_id' => $product->id,
                'product_pricing_id' => $pricing->id,
                'subscription_number' => $subscriptionNumber,
                'status' => $subscriptionData['status'],
                'billing_cycle' => $subscriptionData['billing_cycle'],
                'recurring_amount' => $pricing->recurring_fee,
                'setup_fee' => $pricing->setup_fee,
                'currency' => 'USD',
                'start_date' => $subscriptionData['start_date'],
                'next_billing_date' => $nextBillingDate,
                'end_date' => $subscriptionData['end_date'] ?? null,
                'cancelled_at' => $subscriptionData['cancelled_at'] ?? null,
                'suspended_at' => $subscriptionData['suspended_at'] ?? null,
                'billing_cycles_completed' => $subscriptionData['billing_cycles_completed'],
                'failed_payment_attempts' => $subscriptionData['failed_payment_attempts'] ?? 0,
                'last_billing_date' => $subscriptionData['billing_cycles_completed'] > 0
                    ? $subscriptionData['start_date']->copy()->addMonths($subscriptionData['billing_cycles_completed'] - 1)
                    : null,
                'notes' => $subscriptionData['notes'],
                'metadata' => [
                    'created_by' => 'system_seeder',
                    'source' => 'initial_setup',
                ],
            ]);

            // Create subscription items
            $this->createSubscriptionItems($subscription, $product, $pricing);

            $this->command->info("Created subscription: {$subscriptionNumber} for customer ID {$subscriptionData['customer_id']}");
        }

        $this->command->info('Subscription seeding completed successfully!');
    }

    /**
     * Create subscription items for a subscription
     */
    private function createSubscriptionItems(Subscription $subscription, Product $product, ProductPricing $pricing): void
    {
        // Main product item
        SubscriptionItem::create([
            'subscription_id' => $subscription->id,
            'product_id' => $product->id,
            'type' => SubscriptionItem::TYPE_PRODUCT,
            'description' => $product->name . ' - ' . $pricing->billing_cycle_display,
            'quantity' => 1,
            'unit_price' => $pricing->recurring_fee,
            'total_price' => $pricing->recurring_fee,
            'billing_cycle' => $pricing->billing_cycle,
            'is_active' => true,
            'start_date' => $subscription->start_date,
            'notes' => 'Primary hosting service',
        ]);

        // Setup fee item (if applicable)
        if ($pricing->setup_fee > 0) {
            SubscriptionItem::create([
                'subscription_id' => $subscription->id,
                'product_id' => $product->id,
                'type' => SubscriptionItem::TYPE_FEE,
                'description' => 'Setup Fee - ' . $product->name,
                'quantity' => 1,
                'unit_price' => $pricing->setup_fee,
                'total_price' => $pricing->setup_fee,
                'billing_cycle' => 'one_time',
                'is_active' => false, // Setup fees are one-time
                'start_date' => $subscription->start_date,
                'end_date' => $subscription->start_date,
                'notes' => 'One-time setup fee',
            ]);
        }

        // Random addon items for some subscriptions
        if (rand(1, 3) === 1) { // 33% chance of having addons
            $addonProducts = Product::where('type', 'addon')->get();
            if ($addonProducts->isNotEmpty()) {
                $addon = $addonProducts->random();
                $addonPricing = $addon->pricing->where('billing_cycle', $subscription->billing_cycle)->first();

                if ($addonPricing) {
                    SubscriptionItem::create([
                        'subscription_id' => $subscription->id,
                        'product_id' => $addon->id,
                        'type' => SubscriptionItem::TYPE_ADDON,
                        'description' => $addon->name . ' - Add-on Service',
                        'quantity' => 1,
                        'unit_price' => $addonPricing->recurring_fee,
                        'total_price' => $addonPricing->recurring_fee,
                        'billing_cycle' => $addonPricing->billing_cycle,
                        'is_active' => true,
                        'start_date' => $subscription->start_date,
                        'notes' => 'Additional service addon',
                    ]);
                }
            }
        }
    }

    /**
     * Calculate next billing date based on billing cycle and completed cycles
     */
    private function calculateNextBillingDate(Carbon $startDate, string $billingCycle, int $completedCycles): Carbon
    {
        $nextDate = $startDate->copy();

        // Add completed cycles
        switch ($billingCycle) {
            case 'monthly':
                $nextDate->addMonths($completedCycles + 1);
                break;
            case 'quarterly':
                $nextDate->addMonths(($completedCycles + 1) * 3);
                break;
            case 'semi_annually':
                $nextDate->addMonths(($completedCycles + 1) * 6);
                break;
            case 'annually':
                $nextDate->addYears($completedCycles + 1);
                break;
            default:
                $nextDate->addMonth();
        }

        return $nextDate;
    }
}
