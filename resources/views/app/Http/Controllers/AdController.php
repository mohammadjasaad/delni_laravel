<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::all();
        return response()->json($ads);
    }

    public function create()
    {
        return view('ads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string',
            'category' => 'required|in:عقارات,سيارات',
            'phone' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // رفع الصورة
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
            $validated['image'] = 'uploads/' . $imageName;
        }

        Ad::create($validated);

        return redirect('/ads')->with('success', 'تم نشر الإعلان بنجاح!');
    }

    public function dashboard()
    {
        $ads = Ad::latest()->get();
        return view('dashboard.index', compact('ads'));
    }

    public function myAds()
    {
        $ads = Ad::latest()->get(); // لاحقًا نربطها بالمستخدم
        return view('dashboard.ads', compact('ads'));
    }
}
