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
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_group_id')->constrained()->onDelete('cascade');

            // Basic server information
            $table->string('name');
            $table->string('hostname');
            $table->ipAddress('ip_address');
            $table->integer('port')->default(22);

            // Server type and configuration
            $table->enum('type', ['shared', 'vps', 'dedicated', 'cloud'])->default('shared');
            $table->enum('os', ['linux', 'windows', 'freebsd'])->default('linux');
            $table->string('control_panel')->nullable(); // cpanel, plesk, directadmin, etc.

            // Connection details
            $table->string('username')->nullable();
            $table->text('password')->nullable(); // encrypted
            $table->text('ssh_key')->nullable();

            // Server status and monitoring
            $table->enum('status', ['active', 'inactive', 'maintenance', 'suspended'])->default('active');
            $table->boolean('is_monitored')->default(true);
            $table->timestamp('last_ping')->nullable();
            $table->decimal('cpu_usage', 5, 2)->nullable(); // percentage
            $table->decimal('memory_usage', 5, 2)->nullable(); // percentage
            $table->decimal('disk_usage', 5, 2)->nullable(); // percentage
            $table->integer('uptime_seconds')->nullable();

            // Capacity and limits
            $table->integer('max_accounts')->default(100);
            $table->integer('current_accounts')->default(0);
            $table->decimal('monthly_bandwidth_gb', 10, 2)->nullable();
            $table->decimal('disk_space_gb', 10, 2)->nullable();

            // API configuration
            $table->json('api_config')->nullable(); // Store API endpoints, keys, etc.
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['server_group_id', 'status']);
            $table->index(['type', 'status']);
            $table->index('hostname');
            $table->index('ip_address');
            $table->unique(['hostname', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
