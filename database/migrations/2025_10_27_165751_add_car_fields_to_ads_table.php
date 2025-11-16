<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->string('car_brand')->nullable();
            $table->string('engine_size')->nullable();
            $table->string('doors')->nullable();
            $table->string('body_type')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['car_brand', 'engine_size', 'doors', 'body_type']);
        });
    }
};
