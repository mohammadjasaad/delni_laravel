<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\EmergencyService;

class EmergencyServiceController extends Controller
{
    // ✅ حفظ مركز طوارئ جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'type'  => 'required|string|max:255',
            'city'  => 'required|string|max:255',
            'lat'   => 'required|numeric|between:-90,90',
            'lng'   => 'required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            EmergencyService::create([
                'name'  => $validated['name'],
                'type'  => $validated['type'],
                'city'  => $validated['city'],
                'lat'   => $validated['lat'],
                'lng'   => $validated['lng'],
                'phone' => $validated['phone'] ?? null,
            ]);

            return redirect()
                ->route('emergency_services.create')
                ->with('success', '✅ تم إضافة المركز بنجاح!');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', '❌ حدث خطأ أثناء الحفظ. حاول مجدداً.');
        }
    }

    // ✅ عرض كل الخدمات (مع فلترة اختيارية)
    public function index(Request $request)
    {
        $services = $this->buildQuery($request)->latest()->get();

        return view('emergency_services.index', compact('services'));
    }

    // ✅ API للخريطة (يرجع id أيضاً + كاش خفيف + limit اختياري)
    public function mapData(Request $request)
    {
        // حد النتائج: افتراضي 500، حد أقصى 1000
        $limit = (int) $request->query('limit', 500);
        $limit = max(10, min($limit, 1000));

        $cacheKey = 'emergency.map.' . md5(http_build_query([
            'city' => trim((string) $request->query('city', '')),
            'type' => trim((string) $request->query('type', '')),
            'limit'=> $limit,
        ]));

        $data = Cache::remember($cacheKey, 30, function () use ($request, $limit) {
            return $this->buildQuery($request)
                ->select('id', 'name', 'city', 'type', 'lat', 'lng')
                ->latest()
                ->take($limit)
                ->get();
        });

        return response()->json($data);
    }

    // ✅ صفحة عرض مركز
    public function show($id)
    {
        $service = EmergencyService::findOrFail($id);
        return view('emergency_services.show', compact('service'));
    }

    // ✅ صفحة تعديل مركز
    public function edit($id)
    {
        $service = EmergencyService::findOrFail($id);
        return view('emergency_services.edit', compact('service'));
    }

    // ✅ حفظ التعديلات
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'city'  => 'required|string|max:255',
            'type'  => 'required|string|max:255',
            'lat'   => 'required|numeric|between:-90,90',
            'lng'   => 'required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            $service = EmergencyService::findOrFail($id);
            $service->update([
                'name'  => $validated['name'],
                'city'  => $validated['city'],
                'type'  => $validated['type'],
                'lat'   => $validated['lat'],
                'lng'   => $validated['lng'],
                'phone' => $validated['phone'] ?? null,
            ]);

            return redirect()
                ->route('emergency_services.index')
                ->with('success', '✅ تم تعديل المركز بنجاح!');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', '❌ لم يتم حفظ التعديلات. حاول مجدداً.');
        }
    }

    // ✅ صفحة إضافة مركز جديد
    public function create()
    {
        return view('emergency_services.create');
    }

    // ✅ حذف مركز
    public function destroy($id)
    {
        try {
            $service = EmergencyService::findOrFail($id);
            $service->delete();

            return redirect()
                ->route('emergency_services.index')
                ->with('success', '✅ تم حذف المركز بنجاح.');
        } catch (\Throwable $e) {
            return back()->with('error', '❌ تعذّر حذف المركز.');
        }
    }

    /* ------------------------------------------
     | دالة مساعدة: بناء الاستعلام من البارامترات
     |-------------------------------------------*/
    protected function buildQuery(Request $request)
    {
        $q = EmergencyService::query();

        if ($request->filled('city')) {
            $q->where('city', 'like', '%' . trim($request->city) . '%');
        }

        if ($request->filled('type')) {
            $q->where('type', $request->type);
        }

        return $q;
    }
}
