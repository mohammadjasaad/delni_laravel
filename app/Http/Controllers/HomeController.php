<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // ✅ الإعلانات المميزة (أحدث 4)
        $featuredAds = Ad::orderBy('created_at', 'desc')->take(4)->get();

        // ✅ باقي الإعلانات مع فلترة
        $ads = Ad::query();

        if ($request->city) {
            $ads->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->price_min) {
            $ads->where('price', '>=', $request->price_min);
        }

        if ($request->price_max) {
            $ads->where('price', '<=', $request->price_max);
        }

        if ($request->category) {
            $ads->where('category', $request->category);
        }

        $ads = $ads->orderBy("created_at","desc")->get();

        return view('home', compact('ads', 'featuredAds'));
    }
}
