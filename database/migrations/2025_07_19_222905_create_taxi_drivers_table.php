<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('taxi_drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('car_number');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('status')->default('متاح'); // الحالة: متاح / مشغول
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taxi_drivers');
    }
};
