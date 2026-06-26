<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'branch_id')) {
                    $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete()->after('merchant_id');
                }
                if (!Schema::hasColumn('orders', 'driver_id')) {
                    $table->foreignId('driver_id')->nullable()->constrained('users')->nullOnDelete()->after('branch_id');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'driver_id')) {
                    $table->dropForeign(['driver_id']);
                    $table->dropColumn('driver_id');
                }
                if (Schema::hasColumn('orders', 'branch_id')) {
                    $table->dropForeign(['branch_id']);
                    $table->dropColumn('branch_id');
                }
            });
        }
    }
};
