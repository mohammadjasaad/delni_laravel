<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class MapController extends Controller
{
    public function index()
    {
        $drivers = Driver::whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        return view('taxi.drivers.map', compact('drivers'));
    }
}
