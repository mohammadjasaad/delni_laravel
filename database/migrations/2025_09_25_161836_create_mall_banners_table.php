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
    Schema::create('mall_banners', function (Blueprint $table) {
        $table->id();
        $table->string('title')->nullable();
        $table->string('image_desktop'); // صورة العرض
        $table->string('link')->nullable(); // الرابط عند الضغط
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mall_banners');
    }
};
