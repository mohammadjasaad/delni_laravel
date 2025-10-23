<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // عنوان البانر (اختياري)
            $table->string('image_desktop');     // صورة سطح المكتب
            $table->string('image_mobile')->nullable(); // صورة الموبايل (اختياري)
            $table->string('link')->nullable();  // رابط عند الضغط على البانر
            $table->boolean('active')->default(true); // حالة التفعيل
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
