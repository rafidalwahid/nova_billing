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
        Schema::create('ticket_responses', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // For customer responses
            $table->foreignId('admin_user_id')->nullable()->constrained()->onDelete('set null'); // For staff responses

            // Response information
            $table->enum('type', ['customer', 'staff', 'internal'])->default('staff');
            $table->text('message');
            $table->boolean('is_internal')->default(false);
            $table->json('attachments')->nullable();
            $table->integer('response_time_minutes')->nullable(); // Time to respond in minutes

            $table->timestamps();

            // Indexes for performance
            $table->index(['ticket_id', 'created_at']);
            $table->index(['type', 'is_internal']);
            $table->index('user_id');
            $table->index('admin_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_responses');
    }
};
