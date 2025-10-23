<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mall_banners', function (Blueprint $table) {
            if (!Schema::hasColumn('mall_banners', 'image_mobile')) {
                $table->string('image_mobile')->nullable()->after('image_desktop');
            }

            if (!Schema::hasColumn('mall_banners', 'active')) {
                $table->boolean('active')->default(1)->after('link');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mall_banners', function (Blueprint $table) {
            if (Schema::hasColumn('mall_banners', 'image_mobile')) {
                $table->dropColumn('image_mobile');
            }
            if (Schema::hasColumn('mall_banners', 'active')) {
                $table->dropColumn('active');
            }
        });
    }
};
