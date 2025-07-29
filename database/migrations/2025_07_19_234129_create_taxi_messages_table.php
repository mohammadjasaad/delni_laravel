<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('taxi_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taxi_order_id')->constrained('taxi_orders')->onDelete('cascade');
            $table->string('sender_type'); // user or driver
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taxi_messages');
    }
};
