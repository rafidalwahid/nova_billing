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
        Schema::create('product_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->enum('billing_cycle', ['monthly', 'quarterly', 'semi_annually', 'annually']);
            $table->decimal('setup_fee', 10, 2)->default(0.00);
            $table->decimal('recurring_fee', 10, 2);
            $table->timestamps();

            // Ensure unique pricing per product per billing cycle
            $table->unique(['product_id', 'billing_cycle']);

            // Add indexes for common queries
            $table->index(['product_id', 'billing_cycle']);
            $table->index('billing_cycle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_pricings');
    }
};
