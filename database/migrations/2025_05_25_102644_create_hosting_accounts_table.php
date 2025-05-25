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
        Schema::create('hosting_accounts', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('server_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');

            // Account identification
            $table->string('account_number')->unique();
            $table->string('username')->unique();
            $table->string('domain');
            $table->text('password')->nullable(); // encrypted

            // Account status and lifecycle
            $table->enum('status', ['pending', 'active', 'suspended', 'terminated', 'cancelled'])->default('pending');
            $table->enum('suspension_reason', ['payment', 'abuse', 'maintenance', 'manual'])->nullable();
            $table->timestamp('provisioned_at')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->timestamp('terminated_at')->nullable();

            // Resource usage and limits
            $table->decimal('disk_usage_mb', 12, 2)->default(0);
            $table->decimal('disk_limit_mb', 12, 2)->nullable();
            $table->decimal('bandwidth_usage_mb', 15, 2)->default(0);
            $table->decimal('bandwidth_limit_mb', 15, 2)->nullable();
            $table->integer('email_accounts')->default(0);
            $table->integer('email_limit')->nullable();
            $table->integer('databases')->default(0);
            $table->integer('database_limit')->nullable();
            $table->integer('subdomains')->default(0);
            $table->integer('subdomain_limit')->nullable();

            // Control panel integration
            $table->string('cpanel_username')->nullable();
            $table->text('cpanel_password')->nullable(); // encrypted
            $table->string('cpanel_domain')->nullable();
            $table->json('control_panel_config')->nullable();

            // Backup and security
            $table->boolean('backup_enabled')->default(true);
            $table->timestamp('last_backup')->nullable();
            $table->boolean('ssl_enabled')->default(false);
            $table->string('ssl_type')->nullable(); // free, paid, custom

            // Billing and lifecycle
            $table->decimal('setup_fee', 10, 2)->default(0);
            $table->decimal('monthly_fee', 10, 2)->default(0);
            $table->string('billing_cycle', 50)->default('monthly');
            $table->date('next_due_date')->nullable();

            // Additional metadata
            $table->json('metadata')->nullable(); // Store additional custom data
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable(); // Internal notes

            $table->timestamps();

            // Indexes for performance
            $table->index(['customer_id', 'status']);
            $table->index(['server_id', 'status']);
            $table->index(['product_id', 'status']);
            $table->index(['status', 'next_due_date']);
            $table->index('domain');
            $table->index('provisioned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_accounts');
    }
};
