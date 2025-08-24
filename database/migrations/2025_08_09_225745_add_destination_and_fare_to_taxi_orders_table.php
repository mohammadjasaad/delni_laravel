<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('taxi_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('taxi_orders', 'pickup_lat')) {
                $table->decimal('pickup_lat', 10, 7)->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('taxi_orders', 'pickup_lng')) {
                $table->decimal('pickup_lng', 10, 7)->nullable()->after('pickup_lat');
            }
            if (!Schema::hasColumn('taxi_orders', 'dest_lat')) {
                $table->decimal('dest_lat', 10, 7)->nullable()->after('pickup_lng');
            }
            if (!Schema::hasColumn('taxi_orders', 'dest_lng')) {
                $table->decimal('dest_lng', 10, 7)->nullable()->after('dest_lat');
            }
            if (!Schema::hasColumn('taxi_orders', 'dest_address')) {
                $table->string('dest_address')->nullable()->after('dest_lng');
            }
            if (!Schema::hasColumn('taxi_orders', 'estimated_distance_m')) {
                $table->unsignedInteger('estimated_distance_m')->nullable()->after('dest_address');
            }
            if (!Schema::hasColumn('taxi_orders', 'estimated_duration_s')) {
                $table->unsignedInteger('estimated_duration_s')->nullable()->after('estimated_distance_m');
            }
            if (!Schema::hasColumn('taxi_orders', 'estimated_fare')) {
                $table->unsignedInteger('estimated_fare')->nullable()->after('estimated_duration_s');
            }
        });
    }

    public function down(): void
    {
        Schema::table('taxi_orders', function (Blueprint $table) {
            $table->dropColumn([
                'pickup_lat', 'pickup_lng', 'dest_lat', 'dest_lng',
                'dest_address', 'estimated_distance_m', 'estimated_duration_s', 'estimated_fare'
            ]);
        });
    }
};
