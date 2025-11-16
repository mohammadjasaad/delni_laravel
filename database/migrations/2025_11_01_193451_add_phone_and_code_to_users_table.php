<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            // ✅ لا نضيف phone لأنه موجود بالفعل

            if (!Schema::hasColumn('users', 'whatsapp_code')) {
                $table->string('whatsapp_code')->nullable();
            }

            if (!Schema::hasColumn('users', 'code_sent_at')) {
                $table->timestamp('code_sent_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_code','code_sent_at']);
        });
    }
};
