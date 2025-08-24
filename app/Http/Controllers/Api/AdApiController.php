<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdApiController extends Controller
{
    // 🛠️ Helper لتحويل JSON الصور إلى روابط كاملة
    private function formatImages($imagesJson)
    {
        $images = $imagesJson ? json_decode($imagesJson, true) : [];

        if (!is_array($images)) {
            return [];
        }

        return array_map(function ($img) {
            if (\Illuminate\Support\Str::startsWith($img, ['http://', 'https://'])) {
                return $img;
            }

            // إصلاح المسار لو فيه uploads/
            $img = str_replace('uploads/', '', $img);

            return asset('storage/ads/' . $img);
        }, $images);
    }

    // ✅ جميع الإعلانات
    public function index()
    {
        $ads = Ad::latest()->get()->map(function ($ad) {
            $ad->images = $this->formatImages($ad->images);
            return $ad;
        });

        return response()->json($ads);
    }

    // ✅ إعلان مفرد
    public function show($id)
    {
        $ad = Ad::find($id);

        if (!$ad) {
            return response()->json(['error' => 'الإعلان غير موجود'], 404);
        }

        $ad->images = $this->formatImages($ad->images);

        return response()->json($ad);
    }

    // ✅ إضافة إعلان جديد
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'city'        => 'required|string',
            'category'    => 'required|string',
            'images'      => 'nullable|array',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096'
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('ads', $filename, 'public'); // تخزين في ads
                $imagePaths[] = $filename;
            }
        }

        $ad = Ad::create([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'city'        => $request->city,
            'category'    => $request->category,
            'images'      => json_encode($imagePaths, JSON_UNESCAPED_UNICODE),
            'user_id'     => Auth::id(),
        ]);

        $ad->images = $this->formatImages($ad->images);

        return response()->json([
            'status'  => true,
            'message' => 'تم إنشاء الإعلان بنجاح',
            'ad'      => $ad
        ], 201);
    }

    // ✅ تعديل إعلان
    public function update(Request $request, $id)
    {
        $ad = Ad::find($id);

        if (!$ad || $ad->user_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح'], 403);
        }

        $ad->update($request->only(['title', 'description', 'category', 'city', 'price']));

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('ads', $filename, 'public');
                $imagePaths[] = $filename;
            }
            $ad->images = json_encode($imagePaths, JSON_UNESCAPED_UNICODE);
            $ad->save();
        }

        $ad->images = $this->formatImages($ad->images);

        return response()->json(['message' => 'تم تحديث الإعلان', 'ad' => $ad]);
    }

    // ✅ حذف إعلان
    public function destroy($id)
    {
        $ad = Ad::find($id);

        if (!$ad || $ad->user_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح'], 403);
        }

        $ad->delete();

        return response()->json(['message' => 'تم حذف الإعلان']);
    }

    // ✅ إعلاناتي
    public function myAds()
    {
        $userId = Auth::id();
        $ads = Ad::where('user_id', $userId)->latest()->get()->map(function ($ad) {
            $ad->images = $this->formatImages($ad->images);
            return $ad;
        });

        return response()->json($ads);
    }
}
