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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_pricing_id')->constrained()->onDelete('cascade');

            // Subscription identification
            $table->string('subscription_number', 50)->unique();
            $table->enum('status', ['active', 'suspended', 'cancelled', 'expired', 'pending'])
                  ->default('pending');

            // Billing information
            $table->enum('billing_cycle', ['monthly', 'quarterly', 'semi_annually', 'annually']);
            $table->decimal('recurring_amount', 10, 2);
            $table->decimal('setup_fee', 10, 2)->default(0.00);
            $table->string('currency', 3)->default('USD');

            // Subscription lifecycle dates
            $table->date('start_date');
            $table->date('next_billing_date');
            $table->date('end_date')->nullable();
            $table->date('trial_end_date')->nullable();
            $table->date('cancelled_at')->nullable();
            $table->date('suspended_at')->nullable();

            // Billing tracking
            $table->integer('billing_cycles_completed')->default(0);
            $table->integer('failed_payment_attempts')->default(0);
            $table->date('last_billing_date')->nullable();

            // Additional information
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // For storing additional subscription data

            $table->timestamps();

            // Indexes for performance
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'next_billing_date']);
            $table->index(['product_id', 'status']);
            $table->index('subscription_number');
            $table->index('next_billing_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
