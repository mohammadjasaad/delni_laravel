<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyReport;
use App\Models\EmergencyService;
use App\Models\User;
use Illuminate\Http\Request;

class EmergencyReportController extends Controller
{
    // ✅ عرض جميع البلاغات
    public function index()
    {
        $reports = EmergencyReport::with(['service', 'user'])
            ->orderBy("id","desc")
            ->paginate(20);

        return view('admin.emergency_reports.index', compact('reports'));
    }

    // ✅ عرض بلاغ واحد
    public function show($id)
    {
        $report = EmergencyReport::with(['service', 'user'])
            ->findOrFail($id);

        return view('admin.emergency_reports.show', compact('report'));
    }

    // ✅ تحديث حالة البلاغ
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,resolved,closed'
        ]);

        $report = EmergencyReport::findOrFail($id);
        $report->status = $request->status;
        $report->save();

        // 🟢 إشعار المستخدم (اختياري)
        if ($report->user_id) {
            $user = User::find($report->user_id);
            if ($user) {
                // يمكن إضافة Notification مخصصة
                // $user->notify(new EmergencyReportStatusChanged($report));
            }
        }

        return redirect()->back()->with('success', '✅ تم تحديث حالة البلاغ بنجاح');
    }

    // ✅ حذف البلاغ
    public function destroy($id)
    {
        $report = EmergencyReport::findOrFail($id);
        $report->delete();

        return redirect()->route('admin.emergency_reports.index')
            ->with('success', '🚨 تم حذف البلاغ');
    }

    // ✅ إحصائيات لوحة التحكم
    public function dashboard()
    {
        $totalReports = EmergencyReport::count();
        $newReports = EmergencyReport::where('status', 'pending')->count();
        $processingReports = EmergencyReport::where('status', 'processing')->count();
        $resolvedReports = EmergencyReport::where('status', 'resolved')->count();
        $closedReports = EmergencyReport::where('status', 'closed')->count();
        $totalCenters = EmergencyService::count();

        $topCities = EmergencyService::select('city')
            ->join('emergency_reports', 'emergency_services.id', '=', 'emergency_reports.emergency_service_id')
            ->groupBy('city')
            ->selectRaw('city, COUNT(*) as count')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        return view('admin.emergency_reports.dashboard', compact(
            'totalReports',
            'newReports',
            'processingReports',
            'resolvedReports',
            'closedReports',
            'totalCenters',
            'topCities'
        ));
    }
}
