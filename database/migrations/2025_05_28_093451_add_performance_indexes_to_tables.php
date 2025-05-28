<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add composite indexes for common query patterns (only if they don't exist)

        // Orders table - add only new indexes
        Schema::table('orders', function (Blueprint $table) {
            // Skip customer_id, status index as it already exists
            $table->index(['customer_id', 'ordered_at'], 'orders_customer_date_idx');
            // Skip status, ordered_at index as it already exists
        });

        // Subscriptions table - add only new indexes
        Schema::table('subscriptions', function (Blueprint $table) {
            // Skip customer_id, status index as it already exists
            // Skip status, next_billing_date index as it already exists
            $table->index(['customer_id', 'next_billing_date'], 'subscriptions_customer_billing_idx');
        });

        // Payments table - add only new indexes
        Schema::table('payments', function (Blueprint $table) {
            // Skip customer_id, payment_date index as it already exists
            // Skip invoice_id, status index as it already exists
        });

        // Transactions table - add new indexes
        Schema::table('transactions', function (Blueprint $table) {
            $table->index(['payment_id', 'status'], 'transactions_payment_status_idx');
            $table->index(['processed_at', 'status'], 'transactions_date_status_idx');
        });

        // Order items table - add new indexes
        Schema::table('order_items', function (Blueprint $table) {
            $table->index(['order_id', 'product_id'], 'order_items_order_product_idx');
        });

        // Invoice lines table - add new indexes
        Schema::table('invoice_lines', function (Blueprint $table) {
            $table->index(['invoice_id', 'order_item_id'], 'invoice_lines_invoice_item_idx');
        });

        // Subscription items table - add new indexes
        Schema::table('subscription_items', function (Blueprint $table) {
            $table->index(['subscription_id', 'product_id'], 'subscription_items_sub_product_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_customer_date_idx');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropIndex('subscriptions_customer_billing_idx');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('transactions_payment_status_idx');
            $table->dropIndex('transactions_date_status_idx');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex('order_items_order_product_idx');
        });

        Schema::table('invoice_lines', function (Blueprint $table) {
            $table->dropIndex('invoice_lines_invoice_item_idx');
        });

        Schema::table('subscription_items', function (Blueprint $table) {
            $table->dropIndex('subscription_items_sub_product_idx');
        });
    }
};
