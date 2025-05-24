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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');

            // Invoice identification
            $table->string('invoice_number', 50)->unique();
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled'])
                  ->default('draft');

            // Financial information
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);
            $table->decimal('balance_due', 10, 2)->default(0.00);
            $table->string('currency', 3)->default('USD');

            // Date information
            $table->date('invoice_date');
            $table->date('due_date');
            $table->date('paid_date')->nullable();

            // Additional information
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'due_date']);
            $table->index('invoice_number');
            $table->index(['order_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
