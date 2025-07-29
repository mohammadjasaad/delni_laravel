<?php

namespace App\Http\Controllers;

use App\Models\EmergencyService;
use Illuminate\Http\Request;
use App\Models\EmergencyReport;
use Illuminate\Support\Facades\DB;

class EmergencyReportController extends Controller
{
    /**
     * 📨 تخزين بلاغ جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:emergency_services,id',
            'reason' => 'required|string|max:1000',
        ]);

        EmergencyReport::create([
            'service_id' => $request->service_id,
            'reason' => $request->reason,
        ]);

        return back()->with('success', '✅ تم إرسال البلاغ بنجاح، وسيتم مراجعته قريبًا.');
    }

    // ✅ عرض البلاغات في لوحة تحكم المستخدم
    public function manageReports()
    {
        $reports = EmergencyReport::with('service')->latest()->get();
        return view('dashboard.reports.index', compact('reports'));
    }

    /**
     * 📋 عرض جميع البلاغات في لوحة الإدارة
     */
    public function index()
    {
        $reports = EmergencyReport::with('service')->latest()->get();
        return view('dashboard.emergency_reports.index', compact('reports'));
    }

    /**
     * 📊 عرض إحصائيات مراكز الطوارئ والبلاغات
     */
    public function stats()
    {
        $totalCenters = EmergencyService::count();
        $totalReports = EmergencyReport::count();

        $topCities = EmergencyService::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $topTypes = EmergencyService::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $reportCities = EmergencyReport::join('emergency_services', 'emergency_reports.service_id', '=', 'emergency_services.id')
            ->select('emergency_services.city', DB::raw('count(*) as total'))
            ->groupBy('emergency_services.city')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('emergency_reports.stats', compact(
            'totalCenters', 'totalReports', 'topCities', 'topTypes', 'reportCities'
        ));
    }
}

