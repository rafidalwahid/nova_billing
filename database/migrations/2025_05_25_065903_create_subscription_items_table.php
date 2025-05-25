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
        Schema::create('subscription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');

            // Item details
            $table->enum('type', ['product', 'addon', 'discount', 'fee', 'adjustment'])
                  ->default('product');
            $table->string('description');
            $table->integer('quantity')->default(1);

            // Pricing information
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('billing_cycle', 50)->nullable();

            // Status and lifecycle
            $table->boolean('is_active')->default(true);
            $table->date('start_date');
            $table->date('end_date')->nullable();

            // Additional information
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // For storing additional item data

            $table->timestamps();

            // Indexes for performance
            $table->index(['subscription_id', 'is_active']);
            $table->index(['product_id', 'type']);
            $table->index(['type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_items');
    }
};
