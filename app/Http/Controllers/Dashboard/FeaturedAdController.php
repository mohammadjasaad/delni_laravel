<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;

class FeaturedAdController extends Controller
{
    public function index()
    {
        // ✅ جلب الإعلانات المميزة فقط (نفترض أن هناك حقل is_featured)
        $ads = Ad::where('is_featured', true)->latest()->get();

        return view('dashboard.featured_ads.index', compact('ads'));
    }
}
