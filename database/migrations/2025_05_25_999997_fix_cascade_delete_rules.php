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
        // Fix hosting_accounts foreign keys
        Schema::table('hosting_accounts', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['order_id']);
            $table->dropForeign(['domain_registration_id']);
            
            // Add proper cascade rules
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
            $table->foreign('domain_registration_id')->references('id')->on('domain_registrations')->onDelete('set null');
        });

        // Fix domain_registrations foreign keys
        Schema::table('domain_registrations', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['order_id']);
            $table->dropForeign(['hosting_account_id']);
            
            // Add proper cascade rules
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
            $table->foreign('hosting_account_id')->references('id')->on('hosting_accounts')->onDelete('set null');
        });

        // Fix order_items foreign keys
        Schema::table('order_items', function (Blueprint $table) {
            // Drop existing foreign key
            $table->dropForeign(['order_id']);
            
            // Add proper cascade rule
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        // Fix invoice_lines foreign keys
        Schema::table('invoice_lines', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['invoice_id']);
            $table->dropForeign(['order_item_id']);
            
            // Add proper cascade rules
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('set null');
        });

        // Fix subscription_items foreign keys
        Schema::table('subscription_items', function (Blueprint $table) {
            // Drop existing foreign key
            $table->dropForeign(['subscription_id']);
            
            // Add proper cascade rule
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
        });

        // Fix ticket_responses foreign keys
        Schema::table('ticket_responses', function (Blueprint $table) {
            // Drop existing foreign key
            $table->dropForeign(['ticket_id']);
            
            // Add proper cascade rule
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the changes by restoring original foreign keys
        // This is complex and would require knowing the original constraints
        // For now, we'll leave this empty as this is a fix migration
    }
};
