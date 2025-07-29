<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // 🔗 صاحب التذكرة
            $table->string('subject');        // 📝 عنوان المشكلة
            $table->text('message');          // 💬 وصف المشكلة
            $table->enum('status', ['جديد', 'قيد المعالجة', 'تم الرد', 'مغلق'])->default('جديد');
            $table->timestamps();

            // 🔗 العلاقة بالمستخدم
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
