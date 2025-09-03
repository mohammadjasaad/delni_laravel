<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('emergency_reports', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('reason');
        });
    }

    public function down(): void
    {
        Schema::table('emergency_reports', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
