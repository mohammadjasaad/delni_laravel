<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('emergency_reports', function (Blueprint $table) {
            if (!Schema::hasColumn('emergency_reports', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');

                // 🔗 ربط بالعلاقة مع جدول users
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('emergency_reports', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
