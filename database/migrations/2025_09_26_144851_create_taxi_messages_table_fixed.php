<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('taxi_messages')) {
            Schema::create('taxi_messages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->enum('sender', ['user', 'driver']);
                $table->text('message');
                $table->timestamps();

                $table->foreign('order_id')->references('id')->on('taxi_orders')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('taxi_messages');
    }
};
