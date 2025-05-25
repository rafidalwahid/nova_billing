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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');

            // Transaction details
            $table->enum('type', ['payment', 'refund', 'chargeback', 'fee', 'adjustment'])
                  ->default('payment');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');

            // Gateway information
            $table->string('gateway_transaction_id')->nullable();
            $table->string('gateway_reference')->nullable();
            $table->json('gateway_response')->nullable();

            // Status and timing
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])
                  ->default('pending');
            $table->timestamp('processed_at')->nullable();

            // Additional information
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['payment_id', 'type']);
            $table->index(['customer_id', 'type']);
            $table->index(['status', 'processed_at']);
            $table->index('gateway_transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
