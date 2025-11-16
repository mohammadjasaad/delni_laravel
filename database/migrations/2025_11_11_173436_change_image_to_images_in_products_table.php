<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // ✨ إضافة العمود الجديد
            $table->json('images')->nullable()->after('price');

            // ⚠️ حذف العمود القديم
            $table->dropColumn('image');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // إعادة العمود القديم
            $table->string('image')->nullable();

            // حذف JSON images
            $table->dropColumn('images');
        });
    }
};
