<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string('driver_name'); // اسم السائق
            $table->unsignedTinyInteger('stars'); // عدد النجوم من 1 إلى 5
            $table->text('comment')->nullable(); // التعليق اختياري
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
