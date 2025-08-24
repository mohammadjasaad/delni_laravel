<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Driver;

class DriverApiController extends Controller
{
    /**
     * GET /api/drivers
     * يدعم:
     * - status=متاح|مشغول|...
     * - q=بحث بالاسم/رقم السيارة
     * - bounds=south,west,north,east   (مثال: 41.0,28.8,41.2,29.1)
     * - limit=عدد النتائج (افتراضي 100، أقصى 500)
     */
    public function index(Request $request)
    {
        // حد أقصى آمن
        $limit = (int) $request->integer('limit', 100);
        if ($limit < 1)   $limit = 1;
        if ($limit > 500) $limit = 500;

        // اختيار أسماء الأعمدة الموجودة فعلياً
        $latCol = Schema::hasColumn('drivers', 'lat') ? 'lat' : 'latitude';
        $lngCol = Schema::hasColumn('drivers', 'lng')
            ? 'lng'
            : (Schema::hasColumn('drivers', 'lon') ? 'lon' : 'longitude');

        $q = Driver::query()
            ->whereNotNull($latCol)
            ->whereNotNull($lngCol);

        // فلترة بالحالة
        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }

        // بحث نصي (اسم/رقم السيارة)
        if ($request->filled('q')) {
            $term = trim($request->string('q'));
            $q->where(function ($w) use ($term) {
                $w->where('name', 'like', "%{$term}%")
                  ->orWhere('car_number', 'like', "%{$term}%");
            });
        }

        // حدود الخريطة bounds=south,west,north,east
        if ($request->filled('bounds')) {
            $parts = array_map('trim', explode(',', $request->string('bounds')));
            if (count($parts) === 4) {
                [$south, $west, $north, $east] = array_map('floatval', $parts);
                // whereBetween للعرض والطول
                $q->whereBetween($latCol, [$south, $north])
                  ->whereBetween($lngCol, [$west, $east]);
            }
        }

        $drivers = $q->latest('updated_at')
            ->limit($limit)
            ->get()
            ->map(function ($d) use ($latCol, $lngCol) {
                $lat = $d->{$latCol};
                $lng = $d->{$lngCol};
                if (is_null($lat) || is_null($lng)) {
                    return null;
                }
                return [
                    'id'         => $d->id,
                    'name'       => $d->name,
                    'car_number' => $d->car_number,
                    'status'     => $d->status ?? 'غير معروف',
                    'lat'        => (float) $lat,
                    // نوحّد المخرجات: نعيد lon و lng لتوافق الواجهات القديمة والجديدة
                    'lon'        => (float) $lng,
                    'lng'        => (float) $lng,
                    'updated_at' => optional($d->updated_at)->toISOString(),
                ];
            })
            ->filter()
            ->values();

        // نعيد مصفوفة مباشرة (متوافق مع الاستخدام الحالي في الواجهة)
        return response()->json($drivers);
    }
}
