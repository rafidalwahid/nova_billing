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
        Schema::create('product_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Feature categorization
            $table->string('feature_type', 50); // storage, bandwidth, domains, email, ssl, etc.
            $table->string('feature_key', 100); // disk_space, monthly_bandwidth, domains_included, etc.
            $table->string('feature_value', 255); // 10, unlimited, yes, no, etc.

            // Display configuration
            $table->string('display_name', 100); // "Disk Space", "Monthly Bandwidth", etc.
            $table->integer('display_order')->default(0); // For ordering features in UI
            $table->boolean('is_highlighted')->default(false); // Show prominently in UI

            $table->timestamps();

            // Indexes for performance
            $table->index(['product_id', 'feature_type']);
            $table->index(['product_id', 'display_order']);
            $table->index(['feature_type', 'feature_key']);

            // Unique constraint to prevent duplicate features per product
            $table->unique(['product_id', 'feature_key'], 'unique_product_feature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_features');
    }
};
