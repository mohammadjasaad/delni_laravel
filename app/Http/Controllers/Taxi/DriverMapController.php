<?php

namespace App\Http\Controllers\Taxi;

use App\Http\Controllers\Controller;
use App\Models\Driver;

class DriverMapController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        return view('taxi.drivers.map', compact('drivers'));
    }
}
