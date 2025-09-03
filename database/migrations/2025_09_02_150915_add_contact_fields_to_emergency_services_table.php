<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('emergency_services', function (Blueprint $table) {
        if (!Schema::hasColumn('emergency_services', 'whatsapp')) {
            $table->string('whatsapp')->nullable();
        }
        if (!Schema::hasColumn('emergency_services', 'email')) {
            $table->string('email')->nullable();
        }
    });
}

public function down()
{
    Schema::table('emergency_services', function (Blueprint $table) {
        $table->dropColumn(['whatsapp', 'email']);
    });
}

};
