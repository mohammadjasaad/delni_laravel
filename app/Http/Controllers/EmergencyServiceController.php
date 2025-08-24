<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyService;

class EmergencyServiceController extends Controller
{
    // ✅ عرض كل الخدمات الطارئة على الخريطة
    public function index(Request $request)
    {
        $query = EmergencyService::query();

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $services = $query->orderBy('id','desc')->get();

        return view('emergency_services.index', compact('services'));
    }

    // ✅ API لإرجاع بيانات المواقع بصيغة JSON للخريطة
    public function mapData(Request $request)
    {
        $query = EmergencyService::query();

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $data = $query->get(['name', 'city', 'type', 'lat', 'lng']);

        return response()->json($data);
    }

    // ✅ صفحة عرض مركز معين
    public function show($id)
    {
        $service = EmergencyService::findOrFail($id);
        return view('emergency_services.show', compact('service'));
    }

    // ✅ صفحة تعديل مركز طوارئ
    public function edit($id)
    {
        $service = EmergencyService::findOrFail($id);
        return view('emergency_services.edit', compact('service'));
    }

    // ✅ حفظ التعديلات
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'type' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $service = EmergencyService::findOrFail($id);
        $service->update([
            'name' => $request->name,
            'city' => $request->city,
            'type' => $request->type,
            'lat' => $request->latitude,
            'lng' => $request->longitude,
        ]);

        return redirect()->route('emergency_services.index')->with('success', '✅ تم تعديل المركز بنجاح!');
    }

    // ✅ صفحة إضافة مركز جديد
    public function create()
    {
        return view('emergency_services.create');
    }

    // ✅ حفظ مركز جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        EmergencyService::create($request->only(['name', 'city', 'type', 'lat', 'lng']));

        return redirect()->route('emergency_services.create')->with('success', '✅ تم إضافة المركز بنجاح!');
    }

    // ✅ حذف مركز طوارئ
    public function destroy($id)
    {
        $service = EmergencyService::findOrFail($id);
        $service->delete();

        return redirect()->route('emergency_services.index')->with('success', '✅ تم حذف المركز بنجاح.');
    }
}
