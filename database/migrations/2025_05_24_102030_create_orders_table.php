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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');

            // Order identification
            $table->string('order_number', 50)->unique();
            $table->enum('status', ['pending', 'processing', 'active', 'cancelled', 'fraud'])
                  ->default('pending');

            // Financial information
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);
            $table->string('currency', 3)->default('USD');

            // Additional information
            $table->text('notes')->nullable();
            $table->timestamp('ordered_at')->useCurrent();

            $table->timestamps();

            // Indexes for performance
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'ordered_at']);
            $table->index('order_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
