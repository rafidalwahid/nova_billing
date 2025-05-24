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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_pricing_id')->nullable()->constrained()->onDelete('set null');

            // Product information (snapshot at time of order)
            $table->string('product_name');
            $table->string('billing_cycle', 50);
            $table->integer('quantity')->default(1);

            // Pricing information (snapshot at time of order)
            $table->decimal('unit_price', 10, 2);
            $table->decimal('setup_fee', 10, 2)->default(0.00);
            $table->decimal('total_price', 10, 2);

            // Additional information
            $table->text('description')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['order_id', 'product_id']);
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
