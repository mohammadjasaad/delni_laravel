<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\User;
use App\Models\EmergencyReport;
use App\Models\SupportTicket;
use App\Models\Driver;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ✅ إحصائيات عامة
        $adCount          = Ad::count();
        $userCount        = User::count();
        $reportCount      = EmergencyReport::count();
        $visitorsCount    = DB::table('visitors')->count();
        $driversCount     = Driver::count(); // 🆕 عدد السائقين

        // ✅ إحصائيات إضافية
        $featuredAdsCount = Ad::where('is_featured', 1)->count(); // 🆕 الإعلانات المميزة

        // 🎫 إحصائيات التذاكر
        $ticketsTotal     = SupportTicket::count();
        $ticketsNew       = SupportTicket::where('status', 'جديد')->count();
        $ticketsProcessing= SupportTicket::where('status', 'قيد المعالجة')->count();
        $ticketsAnswered  = SupportTicket::where('status', 'تم الرد')->count();
        $ticketsClosed    = SupportTicket::where('status', 'مغلق')->count();

        // 🚨 عدد البلاغات الجديدة
        $newReportsCount  = EmergencyReport::where('status', 'pending')->count();

        // ✅ آخر 5 إعلانات
        $latestAds = Ad::latest()->take(5)->get();

        // ✅ آخر 5 تذاكر دعم مع بيانات المستخدم
        $latestTickets = SupportTicket::with('user')
            ->latest()
            ->take(5)
            ->get();

        // ✅ آخر 5 زوار
        $latestVisitors = DB::table('visitors')
            ->orderByDesc('visited_at')
            ->limit(5)
            ->get();

        // 📈 نمو المستخدمين والإعلانات آخر 7 أيام
        $userGrowth = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->pluck('total', 'date');

        $adGrowth = Ad::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->pluck('total', 'date');

        return view('admin.dashboard.index', compact(
            'adCount',
            'userCount',
            'reportCount',
            'visitorsCount',
            'driversCount',
            'featuredAdsCount',
            'ticketsTotal',
            'ticketsNew',
            'ticketsProcessing',
            'ticketsAnswered',
            'ticketsClosed',
            'newReportsCount',
            'latestAds',
            'latestTickets',
            'latestVisitors',
            'userGrowth',
            'adGrowth'
        ));
    }
}
