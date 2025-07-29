<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Ad;
use App\Models\EmergencyService;
use App\Models\EmergencyReport;
use App\Models\TaxiDriver;

class StatisticsController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $adCount = Ad::count();
        $emergencyCount = EmergencyService::count();
        $reportCount = EmergencyReport::count();
        $driverCount = TaxiDriver::count();

        // 🔝 أكثر 3 مدن تحتوي إعلانات
        $topAdCities = Ad::select('city', DB::raw('COUNT(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        // 🔝 أكثر 3 مدن تحتوي مراكز طوارئ
        $topEmergencyCities = EmergencyService::select('city', DB::raw('COUNT(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        return view('dashboard.statistics', compact(
            'userCount',
            'adCount',
            'emergencyCount',
            'reportCount',
            'driverCount',
            'topAdCities',
            'topEmergencyCities'
        ));
    }
}
