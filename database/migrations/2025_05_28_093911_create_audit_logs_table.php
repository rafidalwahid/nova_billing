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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // User who performed the action
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // What was affected
            $table->string('auditable_type'); // Model class name
            $table->unsignedBigInteger('auditable_id'); // Model ID
            $table->index(['auditable_type', 'auditable_id']);

            // Action details
            $table->string('event'); // created, updated, deleted, etc.
            $table->string('action_description'); // Human-readable description

            // Data changes
            $table->json('old_values')->nullable(); // Previous values
            $table->json('new_values')->nullable(); // New values

            // Context information
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('metadata')->nullable(); // Additional context

            // Categorization
            $table->string('category')->default('general'); // financial, customer, system, etc.
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium');

            $table->timestamps();

            // Indexes for performance
            $table->index(['user_id', 'created_at']);
            $table->index(['event', 'created_at']);
            $table->index(['category', 'created_at']);
            $table->index(['severity', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
