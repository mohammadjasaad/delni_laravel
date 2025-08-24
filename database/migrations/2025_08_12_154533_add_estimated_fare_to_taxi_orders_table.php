<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('taxi_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('taxi_orders', 'estimated_fare')) {
                $table->unsignedDecimal('estimated_fare', 10, 2)->nullable()->after('duration_min');
            }
        });
    }

    public function down(): void
    {
        Schema::table('taxi_orders', function (Blueprint $table) {
            if (Schema::hasColumn('taxi_orders', 'estimated_fare')) {
                $table->dropColumn('estimated_fare');
            }
        });
    }
};
