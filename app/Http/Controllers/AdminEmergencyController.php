<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyService;

class AdminEmergencyController extends Controller
{
    public function index()
    {
        $centers = EmergencyService::latest()->paginate(12);
        return view('admin.emergency_centers.index', compact('centers'));
    }
}
