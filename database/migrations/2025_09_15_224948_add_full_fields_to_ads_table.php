<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            // 🏠 عقارات
            $table->integer('rooms')->nullable();
            $table->integer('bathrooms')->nullable();

            // ✨ تعديل هنا: بدل area → area_total + area_net
            $table->integer('area_total')->nullable();
            $table->integer('area_net')->nullable();

            $table->integer('floor')->nullable();
            $table->integer('building_age')->nullable();
            $table->boolean('has_elevator')->default(false);
            $table->boolean('has_parking')->default(false);
            $table->string('heating_type')->nullable();
            $table->string('subcategory')->nullable();

            // 🚗 سيارات
            $table->string('car_model')->nullable();
            $table->string('car_year')->nullable();
            $table->integer('car_km')->nullable();
            $table->string('fuel')->nullable();
            $table->string('gearbox')->nullable();
            $table->string('car_color')->nullable();
            $table->boolean('is_new')->default(false);

            // 🛠️ خدمات
            $table->string('service_type')->nullable();
            $table->string('provider_name')->nullable();




            // 🔑 slug
            $table->string('slug')->unique()->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn([
                'rooms','bathrooms','area_total','area_net','floor','building_age','has_elevator','has_parking','heating_type','subcategory',
                'car_model','car_year','car_km','fuel','gearbox','car_color','is_new',
                'service_type','provider_name',
                'lat','lng',
                'slug'
            ]);

            // ✨ رجع العمود القديم إذا عملت rollback
            $table->integer('area')->nullable();
        });
    }
};
