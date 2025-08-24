<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class TaxiDriversMapController extends Controller
{
    public function index()
    {
        return view('taxi.drivers.map');
    }

    /**
     * /taxi/api/drivers — للتوافق مع شيفرات قديمة إن استُخدمت
     * يدعم status + q + bounds بنفس منطق /api/drivers
     */
    public function apiDrivers(Request $request)
    {
        $latExpr = "COALESCE(`lat`, `latitude`)";
        $lngExpr = "COALESCE(`lng`, `lon`, `longitude`)";

        $q = Driver::query()
            ->whereRaw("$latExpr IS NOT NULL AND $lngExpr IS NOT NULL");

        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }

        if ($request->filled('q')) {
            $term = '%' . trim($request->string('q')) . '%';
            $q->where(function ($qq) use ($term) {
                $qq->where('name', 'like', $term)
                   ->orWhere('car_number', 'like', $term);
            });
        }

        if ($request->filled('bounds')) {
            $parts = array_map('trim', explode(',', (string)$request->bounds));
            if (count($parts) === 4) {
                [$s,$w,$n,$e] = array_map('floatval', $parts);
                $q->whereRaw("$latExpr BETWEEN ? AND ?", [$s, $n])
                  ->whereRaw("$lngExpr BETWEEN ? AND ?", [$w, $e]);
            }
        }

        $limit = (int) $request->input('limit', 500);
        $limit = max(1, min($limit, 2000));

        $drivers = $q->orderByDesc('updated_at')
            ->limit($limit)
            ->get()
            ->map(function ($d) {
                $lat = $d->lat ?? $d->latitude ?? null;
                $lng = $d->lng ?? $d->lon ?? $d->longitude ?? null;

                if (is_null($lat) || is_null($lng)) {
                    return null;
                }

                $latF = (float)$lat;
                $lngF = (float)$lng;

                return [
                    'id'         => $d->id,
                    'name'       => $d->name,
                    'car_number' => $d->car_number ?? null,
                    'status'     => $d->status ?? 'غير معروف',
                    'lat'        => $latF,
                    'lng'        => $lngF,
                    'updated_at' => optional($d->updated_at)->toISOString(),
                ];
            })
            ->filter()
            ->values();

        return response()->json(['drivers' => $drivers]);
    }
}
