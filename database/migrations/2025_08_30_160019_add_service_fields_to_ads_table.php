<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            // 🚗 نقل ملكية
            $table->string('vehicle_type')->nullable()->after('category');

            // 🛡️ تأمين سيارات
            $table->string('insurance_type')->nullable()->after('vehicle_type');

            // 🛠️ صيانة
            $table->string('maintenance_type')->nullable()->after('insurance_type');

            // 🏠 تقييم عقار
            $table->string('property_type')->nullable()->after('maintenance_type');

            // 🔨 مزايدات
            $table->string('bidding_type')->nullable()->after('property_type');

            // 💬 خدمة العملاء
            $table->string('support_type')->nullable()->after('bidding_type');
        });
    }

    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn([
                'vehicle_type',
                'insurance_type',
                'maintenance_type',
                'property_type',
                'bidding_type',
                'support_type',
            ]);
        });
    }
};
