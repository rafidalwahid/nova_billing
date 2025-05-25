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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('payment_method_id')->nullable();

            // Payment information
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded', 'cancelled'])
                  ->default('pending');

            // Gateway information
            $table->string('gateway_transaction_id')->nullable();
            $table->json('gateway_response')->nullable();
            $table->string('reference_number')->nullable();

            // Additional information
            $table->text('notes')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['invoice_id', 'status']);
            $table->index(['customer_id', 'payment_date']);
            $table->index(['status', 'payment_date']);
            $table->index('gateway_transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
