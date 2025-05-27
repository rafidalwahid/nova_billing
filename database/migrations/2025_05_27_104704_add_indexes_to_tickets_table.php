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
        Schema::table('tickets', function (Blueprint $table) {
            // Add indexes for frequently queried fields
            $table->index('customer_id', 'idx_tickets_customer_id');
            $table->index('status', 'idx_tickets_status');
            $table->index('priority', 'idx_tickets_priority');
            $table->index('category', 'idx_tickets_category');
            $table->index('created_at', 'idx_tickets_created_at');
            $table->index('updated_at', 'idx_tickets_updated_at');
            $table->index('sla_due_at', 'idx_tickets_sla_due_at');

            // Composite indexes for common query patterns
            $table->index(['customer_id', 'status'], 'idx_tickets_customer_status');
            $table->index(['customer_id', 'created_at'], 'idx_tickets_customer_created');
            $table->index(['status', 'priority'], 'idx_tickets_status_priority');
            $table->index(['status', 'sla_due_at'], 'idx_tickets_status_sla');

            // Full-text search index for subject and description
            $table->fullText(['subject', 'description'], 'idx_tickets_fulltext');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex('idx_tickets_customer_id');
            $table->dropIndex('idx_tickets_status');
            $table->dropIndex('idx_tickets_priority');
            $table->dropIndex('idx_tickets_category');
            $table->dropIndex('idx_tickets_created_at');
            $table->dropIndex('idx_tickets_updated_at');
            $table->dropIndex('idx_tickets_sla_due_at');
            $table->dropIndex('idx_tickets_customer_status');
            $table->dropIndex('idx_tickets_customer_created');
            $table->dropIndex('idx_tickets_status_priority');
            $table->dropIndex('idx_tickets_status_sla');
            $table->dropIndex('idx_tickets_fulltext');
        });
    }
};
