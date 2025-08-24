k<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('taxi_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('taxi_orders', 'status_changed_at')) {
                $table->timestamp('status_changed_at')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('taxi_orders', function (Blueprint $table) {
            if (Schema::hasColumn('taxi_orders', 'status_changed_at')) {
                $table->dropColumn('status_changed_at');
            }
        });
    }
};

