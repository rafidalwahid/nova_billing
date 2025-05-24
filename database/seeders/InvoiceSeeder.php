<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing customers and orders
        $customers = Customer::all();
        $orders = Order::all();

        if ($customers->isEmpty()) {
            $this->command->warn('No customers found. Please run CustomerSeeder first.');
            return;
        }

        // Create sample invoices
        $invoices = [
            [
                'customer_id' => $customers->random()->id,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'invoice_number' => 'INV-000001',
                'status' => Invoice::STATUS_SENT,
                'subtotal' => 299.00,
                'tax_amount' => 29.90,
                'total' => 328.90,
                'balance_due' => 328.90,
                'currency' => 'USD',
                'invoice_date' => Carbon::now()->subDays(5),
                'due_date' => Carbon::now()->addDays(25),
                'notes' => 'Monthly hosting service invoice',
                'terms' => 'Payment due within 30 days of invoice date.',
            ],
            [
                'customer_id' => $customers->random()->id,
                'order_id' => null, // Standalone invoice
                'invoice_number' => 'INV-000002',
                'status' => Invoice::STATUS_PAID,
                'subtotal' => 149.00,
                'tax_amount' => 14.90,
                'total' => 163.90,
                'balance_due' => 0.00,
                'currency' => 'USD',
                'invoice_date' => Carbon::now()->subDays(15),
                'due_date' => Carbon::now()->subDays(15)->addDays(30),
                'paid_date' => Carbon::now()->subDays(10),
                'notes' => 'Domain registration and setup',
                'terms' => 'Payment due within 30 days of invoice date.',
            ],
            [
                'customer_id' => $customers->random()->id,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'invoice_number' => 'INV-000003',
                'status' => Invoice::STATUS_OVERDUE,
                'subtotal' => 599.00,
                'tax_amount' => 59.90,
                'total' => 658.90,
                'balance_due' => 658.90,
                'currency' => 'USD',
                'invoice_date' => Carbon::now()->subDays(45),
                'due_date' => Carbon::now()->subDays(15),
                'notes' => 'VPS hosting service - quarterly billing',
                'terms' => 'Payment due within 30 days of invoice date.',
            ],
            [
                'customer_id' => $customers->random()->id,
                'order_id' => null,
                'invoice_number' => 'INV-000004',
                'status' => Invoice::STATUS_DRAFT,
                'subtotal' => 89.00,
                'tax_amount' => 8.90,
                'total' => 97.90,
                'balance_due' => 97.90,
                'currency' => 'USD',
                'invoice_date' => Carbon::now(),
                'due_date' => Carbon::now()->addDays(30),
                'notes' => 'SSL certificate renewal',
                'terms' => 'Payment due within 30 days of invoice date.',
            ],
            [
                'customer_id' => $customers->random()->id,
                'order_id' => $orders->isNotEmpty() ? $orders->random()->id : null,
                'invoice_number' => 'INV-000005',
                'status' => Invoice::STATUS_PAID,
                'subtotal' => 1299.00,
                'tax_amount' => 129.90,
                'total' => 1428.90,
                'balance_due' => 0.00,
                'currency' => 'USD',
                'invoice_date' => Carbon::now()->subDays(30),
                'due_date' => Carbon::now()->subDays(30)->addDays(30),
                'paid_date' => Carbon::now()->subDays(25),
                'notes' => 'Dedicated server setup and first month',
                'terms' => 'Payment due within 30 days of invoice date.',
            ],
        ];

        foreach ($invoices as $invoiceData) {
            $invoice = Invoice::create($invoiceData);

            // Create invoice lines for each invoice
            $this->createInvoiceLines($invoice);
        }

        $this->command->info('Created ' . count($invoices) . ' sample invoices with line items.');
    }

    /**
     * Create sample invoice lines for an invoice
     */
    private function createInvoiceLines(Invoice $invoice): void
    {
        $lineItems = [];

        switch ($invoice->invoice_number) {
            case 'INV-000001':
                $lineItems = [
                    [
                        'type' => InvoiceLine::TYPE_PRODUCT,
                        'description' => 'Shared Hosting - Business Plan',
                        'quantity' => 1,
                        'unit_price' => 29.99,
                        'total_price' => 29.99,
                        'billing_cycle' => 'monthly',
                    ],
                    [
                        'type' => InvoiceLine::TYPE_PRODUCT,
                        'description' => 'Domain Registration - example.com',
                        'quantity' => 1,
                        'unit_price' => 14.99,
                        'total_price' => 14.99,
                        'billing_cycle' => 'annually',
                    ],
                    [
                        'type' => InvoiceLine::TYPE_SERVICE,
                        'description' => 'Website Migration Service',
                        'quantity' => 1,
                        'unit_price' => 99.00,
                        'total_price' => 99.00,
                    ],
                    [
                        'type' => InvoiceLine::TYPE_PRODUCT,
                        'description' => 'SSL Certificate - Standard',
                        'quantity' => 1,
                        'unit_price' => 49.99,
                        'total_price' => 49.99,
                        'billing_cycle' => 'annually',
                    ],
                    [
                        'type' => InvoiceLine::TYPE_SERVICE,
                        'description' => 'Email Setup Service',
                        'quantity' => 5,
                        'unit_price' => 20.00,
                        'total_price' => 100.00,
                    ],
                    [
                        'type' => InvoiceLine::TYPE_DISCOUNT,
                        'description' => 'New Customer Discount (15%)',
                        'quantity' => 1,
                        'unit_price' => -44.85,
                        'total_price' => -44.85,
                    ],
                ];
                break;

            case 'INV-000002':
                $lineItems = [
                    [
                        'type' => InvoiceLine::TYPE_PRODUCT,
                        'description' => 'Domain Registration - mybusiness.com',
                        'quantity' => 1,
                        'unit_price' => 14.99,
                        'total_price' => 14.99,
                        'billing_cycle' => 'annually',
                    ],
                    [
                        'type' => InvoiceLine::TYPE_PRODUCT,
                        'description' => 'Domain Privacy Protection',
                        'quantity' => 1,
                        'unit_price' => 9.99,
                        'total_price' => 9.99,
                        'billing_cycle' => 'annually',
                    ],
                    [
                        'type' => InvoiceLine::TYPE_SERVICE,
                        'description' => 'DNS Configuration Service',
                        'quantity' => 1,
                        'unit_price' => 49.00,
                        'total_price' => 49.00,
                    ],
                    [
                        'type' => InvoiceLine::TYPE_SERVICE,
                        'description' => 'Domain Setup and Configuration',
                        'quantity' => 1,
                        'unit_price' => 75.00,
                        'total_price' => 75.00,
                    ],
                ];
                break;

            case 'INV-000003':
                $lineItems = [
                    [
                        'type' => InvoiceLine::TYPE_PRODUCT,
                        'description' => 'VPS Hosting - Premium Plan',
                        'quantity' => 1,
                        'unit_price' => 199.00,
                        'total_price' => 597.00,
                        'billing_cycle' => 'quarterly',
                    ],
                    [
                        'type' => InvoiceLine::TYPE_FEE,
                        'description' => 'Setup Fee',
                        'quantity' => 1,
                        'unit_price' => 2.00,
                        'total_price' => 2.00,
                    ],
                ];
                break;

            case 'INV-000004':
                $lineItems = [
                    [
                        'type' => InvoiceLine::TYPE_PRODUCT,
                        'description' => 'SSL Certificate Renewal - Wildcard',
                        'quantity' => 1,
                        'unit_price' => 89.00,
                        'total_price' => 89.00,
                        'billing_cycle' => 'annually',
                    ],
                ];
                break;

            case 'INV-000005':
                $lineItems = [
                    [
                        'type' => InvoiceLine::TYPE_PRODUCT,
                        'description' => 'Dedicated Server - Enterprise',
                        'quantity' => 1,
                        'unit_price' => 299.00,
                        'total_price' => 299.00,
                        'billing_cycle' => 'monthly',
                    ],
                    [
                        'type' => InvoiceLine::TYPE_FEE,
                        'description' => 'Server Setup and Configuration',
                        'quantity' => 1,
                        'unit_price' => 500.00,
                        'total_price' => 500.00,
                    ],
                    [
                        'type' => InvoiceLine::TYPE_SERVICE,
                        'description' => 'Managed Services - Premium Support',
                        'quantity' => 1,
                        'unit_price' => 199.00,
                        'total_price' => 199.00,
                        'billing_cycle' => 'monthly',
                    ],
                    [
                        'type' => InvoiceLine::TYPE_PRODUCT,
                        'description' => 'Backup Service - Enterprise',
                        'quantity' => 1,
                        'unit_price' => 99.00,
                        'total_price' => 99.00,
                        'billing_cycle' => 'monthly',
                    ],
                    [
                        'type' => InvoiceLine::TYPE_PRODUCT,
                        'description' => 'DDoS Protection - Advanced',
                        'quantity' => 1,
                        'unit_price' => 149.00,
                        'total_price' => 149.00,
                        'billing_cycle' => 'monthly',
                    ],
                    [
                        'type' => InvoiceLine::TYPE_PRODUCT,
                        'description' => 'Additional IP Addresses',
                        'quantity' => 5,
                        'unit_price' => 10.00,
                        'total_price' => 50.00,
                        'billing_cycle' => 'monthly',
                    ],
                    [
                        'type' => InvoiceLine::TYPE_DISCOUNT,
                        'description' => 'Annual Payment Discount (10%)',
                        'quantity' => 1,
                        'unit_price' => -129.60,
                        'total_price' => -129.60,
                    ],
                ];
                break;
        }

        foreach ($lineItems as $lineData) {
            $lineData['invoice_id'] = $invoice->id;
            InvoiceLine::create($lineData);
        }
    }
}
