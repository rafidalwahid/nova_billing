<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductPricing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing orders (handle foreign key constraints)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        OrderItem::truncate();
        Order::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create sample orders
        $this->createSampleOrders();
    }

    /**
     * Create realistic sample orders
     */
    private function createSampleOrders(): void
    {
        $customers = Customer::all();
        $products = Product::with('pricing')->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No customers or products found. Please run CustomerSeeder and ProductSeeder first.');
            return;
        }

        $sampleOrders = [
            [
                'customer' => $customers->first(),
                'status' => Order::STATUS_ACTIVE,
                'items' => [
                    ['product' => 'Professional Web Hosting', 'billing_cycle' => 'annually', 'quantity' => 1],
                    ['product' => '.com Domain Registration', 'billing_cycle' => 'annually', 'quantity' => 1],
                    ['product' => 'SSL Certificate - Standard', 'billing_cycle' => 'annually', 'quantity' => 1],
                ],
                'notes' => 'New customer setup - Professional hosting package with domain and SSL.',
            ],
            [
                'customer' => $customers->skip(1)->first(),
                'status' => Order::STATUS_ACTIVE,
                'items' => [
                    ['product' => 'Business Web Hosting', 'billing_cycle' => 'annually', 'quantity' => 1],
                    ['product' => '.com Domain Registration', 'billing_cycle' => 'annually', 'quantity' => 2],
                    ['product' => 'Website Backup Pro', 'billing_cycle' => 'annually', 'quantity' => 1],
                    ['product' => 'CDN Service - Global', 'billing_cycle' => 'annually', 'quantity' => 1],
                ],
                'notes' => 'Business customer upgrade with multiple domains and premium services.',
            ],
            [
                'customer' => $customers->skip(2)->first(),
                'status' => Order::STATUS_PENDING,
                'items' => [
                    ['product' => 'VPS Professional', 'billing_cycle' => 'monthly', 'quantity' => 1],
                    ['product' => 'Dedicated IP Address', 'billing_cycle' => 'monthly', 'quantity' => 1],
                ],
                'notes' => 'VPS upgrade order - pending payment confirmation.',
            ],
            [
                'customer' => $customers->skip(3)->first(),
                'status' => Order::STATUS_ACTIVE,
                'items' => [
                    ['product' => 'Enterprise Web Hosting', 'billing_cycle' => 'annually', 'quantity' => 1],
                    ['product' => '.com Domain Registration', 'billing_cycle' => 'annually', 'quantity' => 5],
                    ['product' => 'SSL Certificate - Wildcard', 'billing_cycle' => 'annually', 'quantity' => 1],
                    ['product' => 'Priority Support Upgrade', 'billing_cycle' => 'annually', 'quantity' => 1],
                ],
                'notes' => 'Enterprise customer with multiple domains and premium support.',
            ],
            [
                'customer' => $customers->skip(4)->first(),
                'status' => Order::STATUS_PROCESSING,
                'items' => [
                    ['product' => 'Dedicated Server - Intel Xeon', 'billing_cycle' => 'monthly', 'quantity' => 1],
                    ['product' => 'Website Security Scanner', 'billing_cycle' => 'monthly', 'quantity' => 1],
                ],
                'notes' => 'Dedicated server order - currently being provisioned.',
            ],
        ];

        foreach ($sampleOrders as $index => $orderData) {
            $order = Order::create([
                'customer_id' => $orderData['customer']->id,
                'order_number' => 'ORD-' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                'status' => $orderData['status'],
                'subtotal' => 0, // Will be calculated
                'tax_amount' => 0, // Will be calculated
                'total' => 0, // Will be calculated
                'currency' => 'USD',
                'notes' => $orderData['notes'],
                'ordered_at' => now()->subDays(rand(1, 30)),
            ]);

            $subtotal = 0;

            foreach ($orderData['items'] as $itemData) {
                $product = $products->firstWhere('name', $itemData['product']);
                if (!$product) {
                    continue;
                }

                $pricing = $product->pricing->firstWhere('billing_cycle', $itemData['billing_cycle']);
                if (!$pricing) {
                    continue;
                }

                $quantity = $itemData['quantity'];
                $unitPrice = $pricing->recurring_fee;
                $setupFee = $pricing->setup_fee;
                $totalPrice = ($quantity * $unitPrice) + $setupFee;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_pricing_id' => $pricing->id,
                    'product_name' => $product->name,
                    'billing_cycle' => $pricing->billing_cycle,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'setup_fee' => $setupFee,
                    'total_price' => $totalPrice,
                    'description' => $product->description,
                ]);

                $subtotal += $totalPrice;
            }

            // Calculate tax (8.5% for example)
            $taxAmount = round($subtotal * 0.085, 2);
            $total = $subtotal + $taxAmount;

            // Update order totals
            $order->update([
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total' => $total,
            ]);
        }
    }
}
