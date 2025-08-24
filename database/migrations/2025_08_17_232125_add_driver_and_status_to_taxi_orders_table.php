<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('taxi_orders', function (Blueprint $table) {
        if (!Schema::hasColumn('taxi_orders', 'driver_id')) {
            $table->unsignedBigInteger('driver_id')->nullable()->after('user_id');
        }
        if (!Schema::hasColumn('taxi_orders', 'status')) {
            $table->string('status')->default('pending')->after('driver_id'); // pending, accepted, en_route, started, completed, cancelled
        }
        // مفيد لتتبع آخر تغيير
        if (!Schema::hasColumn('taxi_orders', 'status_changed_at')) {
            $table->timestamp('status_changed_at')->nullable()->after('status');
        }
    });
}
    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::table('taxi_orders', function (Blueprint $table) {
        if (Schema::hasColumn('taxi_orders', 'status_changed_at')) $table->dropColumn('status_changed_at');
        if (Schema::hasColumn('taxi_orders', 'status')) $table->dropColumn('status');
        if (Schema::hasColumn('taxi_orders', 'driver_id')) $table->dropColumn('driver_id');
    });
}

};
