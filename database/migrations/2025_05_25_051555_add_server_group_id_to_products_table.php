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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('server_group_id')->nullable()->after('is_active')->constrained()->onDelete('set null');
            $table->index(['type', 'server_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['server_group_id']);
            $table->dropIndex(['type', 'server_group_id']);
            $table->dropColumn('server_group_id');
        });
    }
};
