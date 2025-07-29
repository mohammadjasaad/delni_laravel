<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;

class AdApiController extends Controller
{
    // جميع الإعلانات
public function index()
{
    $ads = \App\Models\Ad::latest()->get();

    return response()->json([
        'status' => 'success',
        'ads' => $ads,
    ]);
}
    // إعلان مفرد
    public function show($id)
    {
        $ad = Ad::find($id);
        if (!$ad) {
            return response()->json(['error' => 'الإعلان غير موجود'], 404);
        }
        return response()->json($ad);
    }

    // إضافة إعلان جديد
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'description' => 'required|string',
        'price' => 'required',
        'city' => 'required|string',
        'category' => 'required|string',
        'user_id' => 'required|exists:users,id',
        'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $images = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('ads', 'public');
            $images[] = $path;
        }
    }

    $ad = Ad::create([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'city' => $request->city,
        'category' => $request->category,
        'user_id' => $request->user_id,
        'images' => json_encode($images), // تأكد أن العمود 'images' في جدول ads نوعه TEXT
    ]);

    return response()->json([
        'message' => 'Ad created successfully',
        'ad' => $ad,
    ], 201);
}

    // تعديل إعلان
    public function update(Request $request, $id)
    {
        $ad = Ad::find($id);

        if (!$ad || $ad->user_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح'], 403);
        }

        $ad->update($request->only(['title', 'description', 'category', 'city', 'price']));

        if ($request->has('images')) {
            $ad->images = json_encode($request->images);
            $ad->save();
        }

        return response()->json(['message' => 'تم تحديث الإعلان', 'ad' => $ad]);
    }

    // حذف إعلان
    public function destroy($id)
    {
        $ad = Ad::find($id);

        if (!$ad || $ad->user_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح'], 403);
        }

        $ad->delete();

        return response()->json(['message' => 'تم حذف الإعلان']);
    }
}
