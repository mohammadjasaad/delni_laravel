<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use Illuminate\Support\Facades\Storage;

class AdApiController extends Controller
{
    // ✅ عرض جميع الإعلانات أو البحث
public function index(Request $request)
{
    $query = $request->query('search');

    if ($query) {
        $ads = \App\Models\Ad::where('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->orWhere('city', 'like', "%$query%")
            ->orWhere('category', 'like', "%$query%")
            ->latest()
            ->get();
    } else {
        $ads = \App\Models\Ad::latest()->get();
    }

    // ✅ فك ترميز الصور وتحويلها إلى روابط كاملة
    $ads->transform(function ($ad) {
        $images = json_decode($ad->images, true) ?? [];
        $ad->images = array_map(function ($img) {
            return asset('storage/ads/' . $img);
        }, $images);
        return $ad;
    });

    return response()->json($ads);
}

    // ✅ إضافة إعلان جديد
public function store(Request $request)
{
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'price'       => 'required|numeric',
        'city'        => 'required|string',
        'category'    => 'required|string',
        'images'      => 'required',
        'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:4096',
    ]);

    $imagePaths = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('ads', 'public');
            $imagePaths[] = basename($path);
        }
    }

    $ad = \App\Models\Ad::create([
        'title'       => $request->title,
        'description' => $request->description,
        'price'       => $request->price,
        'city'        => $request->city,
        'category'    => $request->category,
        'images'      => json_encode($imagePaths), // ✅ حفظ كمصفوفة JSON
        'user_id'     => $request->user()->id,
    ]);

    return response()->json($ad, 201);
}

public function myAds(Request $request)
{
    // جلب إعلانات المستخدم الحالي
    $ads = Ad::where('user_id', $request->user()->id)
             ->latest()
             ->get();

    // تحويل الصور إلى روابط مباشرة
    $ads->transform(function ($ad) {
        $ad->images = collect($ad->images)->map(function ($img) {
            return asset('storage/ads/' . $img);
        });
        return $ad;
    });

    return response()->json($ads, 200, [], JSON_UNESCAPED_UNICODE);
}

}
