<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmergencyReport;

class DashboardController extends Controller
{
    public function index()
    {
        $newReportsCount = EmergencyReport::where('status', 'جديد')->count();

        return view('admin.dashboard', compact('newReportsCount'));
    }
}

