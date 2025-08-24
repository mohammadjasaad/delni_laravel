<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function indexExists(string $table, string $index): bool
    {
        $db = DB::getDatabaseName();

        return DB::table('information_schema.statistics')
            ->where('table_schema', $db)
            ->where('table_name', $table)
            ->where('index_name', $index)
            ->exists();
    }

    private function safeAddIndex(string $table, string $column, string $index): void
    {
        if (!Schema::hasColumn($table, $column)) {
            return;
        }
        if ($this->indexExists($table, $index)) {
            return;
        }
        Schema::table($table, function (Blueprint $t) use ($column, $index) {
            $t->index($column, $index);
        });
    }

    private function safeDropIndex(string $table, string $index): void
    {
        if (!$this->indexExists($table, $index)) {
            return;
        }
        Schema::table($table, function (Blueprint $t) use ($index) {
            try {
                $t->dropIndex($index);
            } catch (\Throwable $e) {
                // نتجاهل أي أخطاء إسقاط غير حرجة
            }
        });
    }

    public function up(): void
    {
        $table = 'drivers';

        // فهارس شائعة الاستخدام
        $this->safeAddIndex($table, 'status', 'drivers_status_index');
        $this->safeAddIndex($table, 'updated_at', 'drivers_updated_at_index');

        // فهارس الإحداثيات (ندعم تعدد أسماء الأعمدة)
        foreach (['lat', 'latitude'] as $lat) {
            $this->safeAddIndex($table, $lat, "drivers_{$lat}_index");
        }
        foreach (['lng', 'lon', 'longitude'] as $lng) {
            $this->safeAddIndex($table, $lng, "drivers_{$lng}_index");
        }
    }

    public function down(): void
    {
        $table = 'drivers';
        foreach ([
            'drivers_status_index',
            'drivers_updated_at_index',
            'drivers_lat_index',
            'drivers_latitude_index',
            'drivers_lng_index',
            'drivers_lon_index',
            'drivers_longitude_index',
        ] as $idx) {
            $this->safeDropIndex($table, $idx);
        }
    }
};

