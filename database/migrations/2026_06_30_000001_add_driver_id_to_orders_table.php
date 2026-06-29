<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
<<<<<<< Updated upstream:database/migrations/2026_06_25_173602_change_city_id_to_city_in_orders_table.php
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'city_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['city_id']);
                $table->dropColumn('city_id');
            });
        }
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'city')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('city');
            });
        }
=======
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('driver_id')->nullable()->constrained('users')->nullOnDelete()->after('status_id');
        });
>>>>>>> Stashed changes:database/migrations/2026_06_30_000001_add_driver_id_to_orders_table.php
    }

    public function down(): void
    {
<<<<<<< Updated upstream:database/migrations/2026_06_25_173602_change_city_id_to_city_in_orders_table.php
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'city')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('city');
            });
        }
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'city_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->unsignedBigInteger('city_id');
            });
        }
=======
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
            $table->dropColumn('driver_id');
        });
>>>>>>> Stashed changes:database/migrations/2026_06_30_000001_add_driver_id_to_orders_table.php
    }
};
