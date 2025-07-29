<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('driver_messages', function (Blueprint $table) {
            $table->id();
            $table->enum('sender', ['user', 'driver']); // مرسل الرسالة: المستخدم أو السائق
            $table->text('message'); // نص الرسالة
            $table->timestamps(); // تاريخ الإرسال
        });
    }

    public function down()
    {
        Schema::dropIfExists('driver_messages');
    }
};
