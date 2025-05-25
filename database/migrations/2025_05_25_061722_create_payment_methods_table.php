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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Credit Card, PayPal, Bank Transfer, etc.
            $table->string('gateway')->nullable(); // stripe, paypal, manual, etc.
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->json('config')->nullable(); // Gateway configuration
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Icon class or image path
            $table->timestamps();

            // Indexes
            $table->index(['is_active', 'display_order']);
            $table->index('gateway');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
