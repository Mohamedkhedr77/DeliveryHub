<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('governorates')) {
            Schema::create('governorates', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->timestamps();
                $table->decimal('shipping_price', 10, 2)->default(0);
            });
        }

        if (!Schema::hasTable('cities')) {
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('governorate_id')->constrained('governorates')->cascadeOnDelete();
                $table->string('name', 100);
                $table->decimal('delivery_price', 10, 2);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('statuses')) {
            Schema::create('statuses', function (Blueprint $table) {
                $table->id();
                $table->string('name', 50)->unique();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('merchant_id')->constrained('users');
                $table->string('customer_name');
                $table->string('customer_phone', 20);
                $table->text('address');
                $table->foreignId('governorate_id')->constrained('governorates');
                $table->foreignId('status_id')->constrained('statuses');
                $table->decimal('total_price', 10, 2)->nullable();
                $table->decimal('weight', 8, 2)->nullable();
                $table->text('notes')->nullable();
                $table->string('city')->nullable();
                $table->decimal('order_value', 10, 2);
                $table->boolean('is_village')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('branches')) {
            Schema::create('branches', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->text('address')->nullable();
                $table->string('phone', 20)->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('order_status_logs')) {
            Schema::create('order_status_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $table->foreignId('status_id')->constrained('statuses');
                $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('rejection_reasons')) {
            Schema::create('rejection_reasons', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $table->text('reason');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('rejection_reasons');
        Schema::dropIfExists('order_status_logs');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('governorates');
    }
};
