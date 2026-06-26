<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
    }

    public function down(): void
    {
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
    }
};