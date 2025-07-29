<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EmergencyCenter;
use App\Models\EmergencyReport;

class StatisticsController extends Controller
{
    public function index()
    {
        return view('admin.statistics', [
            'adsCount' => Ad::count(),
            'usersCount' => User::count(),
            'emergencyCount' => EmergencyCenter::count(),
            'reportsCount' => EmergencyReport::count(),
        ]);
    }
}
