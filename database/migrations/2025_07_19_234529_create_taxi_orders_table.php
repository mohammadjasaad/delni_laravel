<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
Schema::create('taxi_orders', function (Blueprint $table) {
    $table->id();
    $table->string('user_name');
    $table->decimal('pickup_latitude', 10, 6);
    $table->decimal('pickup_longitude', 10, 6);
    $table->unsignedBigInteger('driver_id');
    $table->string('status')->default('قيد التنفيذ');
    $table->timestamps();

    $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('taxi_orders');
    }
};
