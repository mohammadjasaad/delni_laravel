<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyReport;
use App\Models\EmergencyService;

class EmergencyStatisticsController extends Controller
{
    public function index()
    {
        $totalReports = EmergencyReport::count();
        $totalServices = EmergencyService::count();
        $topCities = EmergencyService::select('city')
            ->groupBy('city')
            ->selectRaw('count(*) as count, city')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return view('emergency_statistics.index', compact('totalReports', 'totalServices', 'topCities'));
    }
}
