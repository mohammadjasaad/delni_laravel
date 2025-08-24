<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            // نضيف driver_id لو غير موجود
            if (!Schema::hasColumn('ratings', 'driver_id')) {
                $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete()->after('id');
            }

            // نضيف order_id لو غير موجود (اختياري لكنه مفيد)
            if (!Schema::hasColumn('ratings', 'order_id')) {
                $table->foreignId('order_id')->nullable()->constrained('taxi_orders')->nullOnDelete()->after('driver_id');
            }

            // نضمن وجود driver_name لو ناقص
            if (!Schema::hasColumn('ratings', 'driver_name')) {
                $table->string('driver_name', 255)->nullable()->after('order_id');
            }

            // نضمن وجود rating لو ناقص
            if (!Schema::hasColumn('ratings', 'rating')) {
                $table->unsignedTinyInteger('rating')->after('driver_name');
            }

            // نضمن وجود comment لو ناقص
            if (!Schema::hasColumn('ratings', 'comment')) {
                $table->text('comment')->nullable()->after('rating');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            // إسقاط القيود والأعمدة إن كانت موجودة
            if (Schema::hasColumn('ratings', 'order_id')) {
                $table->dropForeign(['order_id']);
                $table->dropColumn('order_id');
            }

            if (Schema::hasColumn('ratings', 'driver_id')) {
                $table->dropForeign(['driver_id']);
                $table->dropColumn('driver_id');
            }

            if (Schema::hasColumn('ratings', 'driver_name')) {
                $table->dropColumn('driver_name');
            }

            if (Schema::hasColumn('ratings', 'rating')) {
                $table->dropColumn('rating');
            }

            if (Schema::hasColumn('ratings', 'comment')) {
                $table->dropColumn('comment');
            }
        });
    }
};
