<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxiDriver;

class TaxiMapController extends Controller
{
    public function index()
    {
        $drivers = TaxiDriver::where('status', 'متاح')->get();
        return view('taxi.driver-map', compact('drivers'));
    }
}
