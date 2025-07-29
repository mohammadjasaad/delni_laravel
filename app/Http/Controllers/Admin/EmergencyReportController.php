<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyReport;
use App\Models\EmergencyService;
use Illuminate\Http\Request;
use App\Notifications\OrderStatusChanged;

class EmergencyReportController extends Controller
{
    public function index()
    {
        $reports = EmergencyReport::with('service')->latest()->get();
        return view('admin.emergency_reports.index', compact('reports'));
    }

    public function show($id)
    {
        $report = EmergencyReport::with('service')->findOrFail($id);
        return view('admin.emergency_reports.show', compact('report'));
    }

    public function updateStatus(Request $request, $id)
    {
        $report = EmergencyReport::findOrFail($id);
        $report->status = $request->input('status');
        $report->save();

        // 🟡 ملاحظة: إذا كنت تريد إعلام المستخدم عبر Notification، يجب أولًا أن تحدد المستخدم!
        // مثلاً إذا كان البلاغ يحتوي user_id:
        // $user = User::find($report->user_id);
        // if ($user) {
        //     $user->notify(new OrderStatusChanged('تمت مراجعة بلاغك وتم تغيير حالته إلى "قيد المعالجة"'));
        // }

        return redirect()->back()->with('success', 'تم تحديث حالة البلاغ بنجاح.');
    }

    public function destroy($id)
    {
        $report = EmergencyReport::findOrFail($id);
        $report->delete();

        return redirect()->route('admin.emergency_reports.index')->with('success', 'تم حذف البلاغ.');
    }

    public function dashboard()
    {
        $totalReports = EmergencyReport::count();
        $newReports = EmergencyReport::where('status', 'جديد')->count();
        $processingReports = EmergencyReport::where('status', 'جارٍ المعالجة')->count();
        $resolvedReports = EmergencyReport::where('status', 'تم الحل')->count();
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
            'totalCenters',
            'topCities'
        ));
    }
}
