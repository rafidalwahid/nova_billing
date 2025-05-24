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
        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_item_id')->nullable()->constrained()->onDelete('set null');

            // Line item information
            $table->enum('type', ['product', 'service', 'discount', 'tax', 'fee'])
                  ->default('product');
            $table->string('description');
            $table->integer('quantity')->default(1);

            // Pricing information
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);

            // Additional details
            $table->string('billing_cycle', 50)->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['invoice_id', 'type']);
            $table->index('order_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_lines');
    }
};
