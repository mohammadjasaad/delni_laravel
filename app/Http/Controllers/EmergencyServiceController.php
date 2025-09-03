<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\EmergencyService;

class EmergencyServiceController extends Controller
{
    // عرض القائمة + الخريطة
    public function index(Request $request)
    {
        $query = EmergencyService::query();

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // ✅ إذا المستخدم أرسل موقعه نحسب المسافة
        if ($request->filled('lat') && $request->filled('lng')) {
            $lat = $request->lat;
            $lng = $request->lng;

            $query->selectRaw("*, 
                (6371 * acos(cos(radians(?)) * cos(radians(lat)) 
                * cos(radians(lng) - radians(?)) 
                + sin(radians(?)) * sin(radians(lat)))) AS distance",
                [$lat, $lng, $lat]
            )->orderBy('distance', 'asc');
        } else {
            // آمن لو جدولك ما فيه created_at
            if (Schema::hasColumn('emergency_services', 'created_at')) {
                $query->orderBy("created_at", "desc");
            } else {
                $query->orderBy('id', 'desc');
            }
        }

        $services = $query->get();

        return view('emergency_services.index', compact('services'));
    }

    // بيانات الخريطة بصيغة JSON
    public function mapData(Request $request)
    {
        $query = EmergencyService::query();

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        return response()->json(
            $query->get(['id', 'name', 'city', 'type', 'lat', 'lng', 'phone', 'description', 'whatsapp', 'email'])
        );
    }

    // عرض تفاصيل مركز + المراكز القريبة
    public function show($id, Request $request)
    {
        $service = EmergencyService::findOrFail($id);

        // ✅ المراكز القريبة من هذا المركز
        $nearby = EmergencyService::selectRaw("*, 
            (6371 * acos(cos(radians(?)) * cos(radians(lat)) 
            * cos(radians(lng) - radians(?)) 
            + sin(radians(?)) * sin(radians(lat)))) AS distance",
            [$service->lat, $service->lng, $service->lat]
        )
        ->where('id', '!=', $service->id)
        ->orderBy('distance', 'asc')
        ->limit(5)
        ->get();

        return view('emergency_services.show', compact('service', 'nearby'));
    }

    // تعديل مركز
    public function edit($id)
    {
        $service = EmergencyService::findOrFail($id);
        return view('emergency_services.edit', compact('service'));
    }

    // تحديث مركز
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'city'       => 'required|string|max:255',
            'type'       => 'required|string|max:255',
            'lat'        => 'required|numeric',
            'lng'        => 'required|numeric',
            'phone'      => 'nullable|string|max:255',
            'description'=> 'nullable|string',
            'whatsapp'   => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:255',
        ]);

        $service = EmergencyService::findOrFail($id);
        $service->update($request->only([
            'name', 'city', 'type', 'lat', 'lng',
            'phone', 'description', 'whatsapp', 'email'
        ]));

        return redirect()->route('emergency_services.show', $service->id)
            ->with('success', '✅ تم تعديل المركز بنجاح!');
    }

    // إنشاء مركز جديد
    public function create()
    {
        return view('emergency_services.create');
    }

    // تخزين مركز جديد
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'type'       => 'required|string|max:255',
            'city'       => 'required|string|max:255',
            'lat'        => 'required|numeric',
            'lng'        => 'required|numeric',
            'phone'      => 'nullable|string|max:255',
            'description'=> 'nullable|string',
            'whatsapp'   => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:255',
        ]);

        EmergencyService::create($request->only([
            'name', 'city', 'type', 'lat', 'lng',
            'phone', 'description', 'whatsapp', 'email'
        ]));

        return redirect()->route('emergency_services.create')
            ->with('success', '✅ تم إضافة المركز بنجاح!');
    }

    // حذف مركز
    public function destroy($id)
    {
        $service = EmergencyService::findOrFail($id);
        $service->delete();

        return redirect()->route('emergency_services.index')
            ->with('success', '✅ تم حذف المركز بنجاح.');
    }
}
