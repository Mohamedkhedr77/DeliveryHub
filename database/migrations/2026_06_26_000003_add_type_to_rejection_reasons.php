<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('rejection_reasons')) {
            Schema::table('rejection_reasons', function (Blueprint $table) {
                if (!Schema::hasColumn('rejection_reasons', 'type')) {
                    $table->string('type')->default('driver_rejection')->after('order_id');
                }
                if (!Schema::hasColumn('rejection_reasons', 'driver_id')) {
                    $table->foreignId('driver_id')->nullable()->constrained('users')->nullOnDelete()->after('type');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('rejection_reasons')) {
            Schema::table('rejection_reasons', function (Blueprint $table) {
                if (Schema::hasColumn('rejection_reasons', 'driver_id')) {
                    $table->dropForeign(['driver_id']);
                    $table->dropColumn('driver_id');
                }
                if (Schema::hasColumn('rejection_reasons', 'type')) {
                    $table->dropColumn('type');
                }
            });
        }
    }
};
