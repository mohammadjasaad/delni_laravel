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
    Schema::create('emergency_services', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('type'); // نوع الخدمة: رافعة، كهرباء، ميكانيك...
        $table->string('phone')->nullable();
        $table->text('description')->nullable();
        $table->string('city')->nullable();
        $table->decimal('lat', 10, 7); // خط العرض
        $table->decimal('lng', 10, 7); // خط الطول
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_services');
    }
};
