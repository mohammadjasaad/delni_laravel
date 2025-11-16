<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('taxi_orders', function (Blueprint $table) {
            
            if (!Schema::hasColumn('taxi_orders', 'distance_km')) {
                $table->decimal('distance_km', 8, 2)->nullable()->after('status');
            }

            if (!Schema::hasColumn('taxi_orders', 'fare_syp')) {
                $table->integer('fare_syp')->nullable()->after('distance_km');
            }

            if (!Schema::hasColumn('taxi_orders', 'route_polyline')) {
                $table->mediumText('route_polyline')->nullable()->after('fare_syp');
            }

        });
    }

    public function down(): void
    {
        Schema::table('taxi_orders', function (Blueprint $table) {
            
            if (Schema::hasColumn('taxi_orders', 'distance_km')) {
                $table->dropColumn('distance_km');
            }

            if (Schema::hasColumn('taxi_orders', 'fare_syp')) {
                $table->dropColumn('fare_syp');
            }

            if (Schema::hasColumn('taxi_orders', 'route_polyline')) {
                $table->dropColumn('route_polyline');
            }

        });
    }
};
