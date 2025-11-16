<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('taxi_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('taxi_orders', 'pickup_lat')) {
                $table->decimal('pickup_lat', 10, 7)->nullable();
                $table->decimal('pickup_lng', 10, 7)->nullable();
                $table->decimal('dropoff_lat',10, 7)->nullable();
                $table->decimal('dropoff_lng',10, 7)->nullable();
            }
            if (!Schema::hasColumn('taxi_orders', 'distance_km')) {
                $table->decimal('distance_km', 8, 2)->nullable();
            }
            if (!Schema::hasColumn('taxi_orders', 'fare_syp')) {
                $table->integer('fare_syp')->nullable();
            }
            if (!Schema::hasColumn('taxi_orders', 'route_polyline')) {
                $table->mediumText('route_polyline')->nullable();
            }
            if (!Schema::hasColumn('taxi_orders', 'status')) {
                $table->string('status')->default('pending'); // pending, assigned, enroute, started, completed, canceled
            }
            if (!Schema::hasColumn('taxi_orders', 'driver_id')) {
                $table->unsignedBigInteger('driver_id')->nullable()->index();
            }
        });
    }

    public function down(): void {
        Schema::table('taxi_orders', function (Blueprint $table) {
            // اتركها كما هي أو احذف الأعمدة إن أردت
        });
    }
};
