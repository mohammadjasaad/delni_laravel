<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('ads', function (Blueprint $table) {
        if (!Schema::hasColumn('ads', 'car_brand')) {
            $table->string('car_brand')->nullable();
        }
        if (!Schema::hasColumn('ads', 'engine_size')) {
            $table->string('engine_size')->nullable();
        }
        if (!Schema::hasColumn('ads', 'doors')) {
            $table->string('doors')->nullable();
        }
        if (!Schema::hasColumn('ads', 'body_type')) {
            $table->string('body_type')->nullable();
        }
    });
}

public function down(): void
{
    Schema::table('ads', function (Blueprint $table) {
        if (Schema::hasColumn('ads', 'car_brand')) {
            $table->dropColumn('car_brand');
        }
        if (Schema::hasColumn('ads', 'engine_size')) {
            $table->dropColumn('engine_size');
        }
        if (Schema::hasColumn('ads', 'doors')) {
            $table->dropColumn('doors');
        }
        if (Schema::hasColumn('ads', 'body_type')) {
            $table->dropColumn('body_type');
        }
    });
}
};
