<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
Schema::create('ads', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2)->nullable();
    $table->string('city')->nullable();
    $table->string('category')->nullable();
    $table->json('images')->nullable();

    // 🔽 هذا هو السطر الجديد
    $table->foreignId('user_id')->constrained()->onDelete('cascade');

    $table->timestamps();
});

}

    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};

