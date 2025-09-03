<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 🟢 تحويل القيم من العربي إلى الإنجليزي
        DB::table('emergency_reports')->where('status', 'جديد')->update(['status' => 'pending']);
        DB::table('emergency_reports')->where('status', 'جارٍ المعالجة')->update(['status' => 'processing']);
        DB::table('emergency_reports')->where('status', 'تم الحل')->update(['status' => 'resolved']);
        DB::table('emergency_reports')->where('status', 'مغلق')->update(['status' => 'closed']);
    }

    public function down(): void
    {
        // 🔄 رجوع من الإنجليزي إلى العربي
        DB::table('emergency_reports')->where('status', 'pending')->update(['status' => 'جديد']);
        DB::table('emergency_reports')->where('status', 'processing')->update(['status' => 'جارٍ المعالجة']);
        DB::table('emergency_reports')->where('status', 'resolved')->update(['status' => 'تم الحل']);
        DB::table('emergency_reports')->where('status', 'closed')->update(['status' => 'مغلق']);
    }
};
