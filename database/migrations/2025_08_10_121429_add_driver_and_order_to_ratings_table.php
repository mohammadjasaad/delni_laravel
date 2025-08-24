<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('ratings', function (Blueprint $table) {
            if (!Schema::hasColumn('ratings', 'driver_id')) {
                $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete()->after('id');
            }
            if (!Schema::hasColumn('ratings', 'order_id')) {
                $table->foreignId('order_id')->nullable()->constrained('taxi_orders')->nullOnDelete()->after('driver_id');
            }
            if (!Schema::hasColumn('ratings', 'driver_name')) {
                $table->string('driver_name', 255)->nullable()->after('order_id');
            }
            if (!Schema::hasColumn('ratings', 'rating')) {
                $table->unsignedTinyInteger('rating')->after('driver_name');
            }
            if (!Schema::hasColumn('ratings', 'comment')) {
                $table->text('comment')->nullable()->after('rating');
            }
        });
    }

    public function down(): void {
        Schema::table('ratings', function (Blueprint $table) {
            if (Schema::hasColumn('ratings', 'order_id')) { $table->dropForeign(['order_id']); $table->dropColumn('order_id'); }
            if (Schema::hasColumn('ratings', 'driver_id')) { $table->dropForeign(['driver_id']); $table->dropColumn('driver_id'); }
            if (Schema::hasColumn('ratings', 'driver_name')) { $table->dropColumn('driver_name'); }
            if (Schema::hasColumn('ratings', 'rating')) { $table->dropColumn('rating'); }
            if (Schema::hasColumn('ratings', 'comment')) { $table->dropColumn('comment'); }
        });
    }
};
