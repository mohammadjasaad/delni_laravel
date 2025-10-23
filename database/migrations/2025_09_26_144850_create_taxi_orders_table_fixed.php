<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('taxi_orders')) {
            Schema::create('taxi_orders', function (Blueprint $table) {
                $table->id();
                $table->string('user_name')->nullable();
                $table->unsignedBigInteger('driver_id')->nullable();
                $table->decimal('pickup_latitude', 10, 7)->nullable();
                $table->decimal('pickup_longitude', 10, 7)->nullable();
                $table->decimal('dropoff_latitude', 10, 7)->nullable();
                $table->decimal('dropoff_longitude', 10, 7)->nullable();
                $table->enum('status', ['pending', 'accepted', 'ongoing', 'completed', 'cancelled', 'منتهي', 'قيد التنفيذ'])->default('pending');
                $table->integer('rating')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('taxi_orders');
    }
};
