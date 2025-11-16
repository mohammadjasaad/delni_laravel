<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaxiController extends Controller
{
    // صفحة اختيار الدور (راكب/سائق)
    public function landing()
    {
        return view('taxi.landing');
    }

    // واجهة الراكب (الخريطة + التسعير)
    public function rider()
    {
        return view('taxi.rider');
    }
}
