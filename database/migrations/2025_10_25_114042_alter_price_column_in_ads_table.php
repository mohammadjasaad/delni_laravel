<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            // ✅ تغيير نوع العمود إلى BIGINT أو DECIMAL
            $table->decimal('price', 15, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            // ⚙️ العودة إلى INT في حال الرجوع
            $table->integer('price')->change();
        });
    }
};
