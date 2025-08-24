<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('taxi_orders', function (Blueprint $table) {
        $table->decimal('dropoff_latitude', 10, 7)->nullable();
        $table->decimal('dropoff_longitude', 10, 7)->nullable();
        $table->string('destination_name')->nullable();
        $table->decimal('distance_km', 8, 2)->nullable();
        $table->integer('duration_min')->nullable();
        $table->decimal('cost', 8, 2)->nullable();
    });
}

public function down()
{
    Schema::table('taxi_orders', function (Blueprint $table) {
        $table->dropColumn([
            'dropoff_latitude', 'dropoff_longitude', 'destination_name',
            'distance_km', 'duration_min', 'cost'
        ]);
    });
}

};
