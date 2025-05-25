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
        Schema::create('server_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('fill_method', ['round_robin', 'least_used', 'manual'])->default('round_robin');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Add indexes for common queries
            $table->index(['is_active', 'fill_method']);
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_groups');
    }
};
