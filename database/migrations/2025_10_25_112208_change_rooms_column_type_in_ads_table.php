<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // ✅ 1. أنشئ عمود مؤقت جديد من نوع string
        Schema::table('ads', function (Blueprint $table) {
            $table->string('rooms_tmp', 20)->nullable()->after('rooms');
        });

        // ✅ 2. انسخ البيانات القديمة إلى العمود الجديد كنص
        DB::statement('UPDATE ads SET rooms_tmp = rooms');

        // ✅ 3. احذف العمود القديم
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn('rooms');
        });

        // ✅ 4. أعد تسمية العمود المؤقت إلى الاسم الأصلي
        Schema::table('ads', function (Blueprint $table) {
            $table->renameColumn('rooms_tmp', 'rooms');
        });

        // ✅ 5. عدّل الأعمدة الأخرى بأمان
        Schema::table('ads', function (Blueprint $table) {
            $table->string('bathrooms', 20)->nullable()->change();
            $table->string('floor', 20)->nullable()->change();
            $table->string('building_age', 20)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->integer('rooms')->change();
            $table->integer('bathrooms')->nullable()->change();
            $table->integer('floor')->nullable()->change();
            $table->integer('building_age')->nullable()->change();
        });
    }
};
