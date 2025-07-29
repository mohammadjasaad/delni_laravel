<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ad;
use App\Models\EmergencyCenter;
use App\Models\EmergencyReport;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        $adsCount = Ad::count();
        $featuredAdsCount = Ad::where('is_featured', 1)->count();
        $usersCount = User::count();
        $emergencyCentersCount = EmergencyCenter::count();
        $reportsCount = EmergencyReport::count();

        $topCities = Ad::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.statistics', compact(
            'adsCount',
            'featuredAdsCount',
            'usersCount',
            'emergencyCentersCount',
            'reportsCount',
            'topCities'
        ));
    }
}
