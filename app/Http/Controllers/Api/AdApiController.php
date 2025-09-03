<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdApiController extends Controller
{
    // ✅ كل الإعلانات
    public function index()
    {
        $ads = Ad::with('user')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $ads->transform(function ($ad) {
            $ad->images = collect($ad->images)->map(fn($img) => Storage::url($img));
            return $ad;
        });

        return response()->json([
            'status' => 'success',
            'ads'    => $ads,
        ]);
    }

    // ✅ إعلاناتي
    public function myAds()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $ads = Ad::where('user_id', $user->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $ads->transform(function ($ad) {
            $ad->images = collect($ad->images)->map(fn($img) => Storage::url($img));
            return $ad;
        });

        return response()->json([
            'status' => 'success',
            'ads'    => $ads,
        ]);
    }

    // ✅ عرض إعلان واحد
    public function show($id)
    {
        $ad = Ad::with('user')->find($id);
        if (!$ad) {
            return response()->json(['error' => 'Ad not found'], 404);
        }

        $ad->images = collect($ad->images)->map(fn($img) => Storage::url($img));

        return response()->json([
            'status' => 'success',
            'ad'     => $ad,
        ]);
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
            'lat'         => 'nullable|numeric',
            'lng'         => 'nullable|numeric',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $ad = new Ad();
        $ad->title       = $request->title;
        $ad->description = $request->description;
        $ad->price       = $request->price;
        $ad->city        = $request->city;
        $ad->category    = $request->category;
        $ad->lat         = $request->lat;
        $ad->lng         = $request->lng;
        $ad->user_id     = auth()->id();

        $imagesArray = [];
        if ($request->hasFile('images')) {
            $files = is_array($request->file('images')) ? $request->file('images') : [$request->file('images')];
            foreach ($files as $image) {
                $imagesArray[] = $image->store('uploads', 'public');
            }
        } elseif ($request->filled('images')) {
            $decoded = json_decode($request->images, true);
            if (is_array($decoded)) $imagesArray = $decoded;
        }

        $ad->images = $imagesArray;
        $ad->save();

        $ad->images = collect($ad->images)->map(fn($img) => Storage::url($img));

        return response()->json([
            'status'  => 'success',
            'message' => 'Ad created successfully',
            'ad'      => $ad
        ], 201);
    }

    // ✅ تعديل إعلان (استبدال الصور)
    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $ad   = Ad::find($id);

            if (!$ad) {
                return response()->json(['error' => 'Ad not found'], 404);
            }
            if ($ad->user_id !== $user->id) {
                return response()->json(['error' => 'Forbidden'], 403);
            }

            $validator = Validator::make($request->all(), [
                'title'       => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'price'       => 'sometimes|numeric',
                'city'        => 'sometimes|string|max:255',
                'category'    => 'sometimes|string|max:255',
                'lat'         => 'nullable|numeric',
                'lng'         => 'nullable|numeric',
                'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Validation failed',
                    'errors'  => $validator->errors()
                ], 422);
            }

            $data = $request->only(['title','description','price','city','category','lat','lng','is_featured']);

            if ($request->hasFile('images')) {
                foreach ($ad->images ?? [] as $old) {
                    Storage::disk('public')->delete($old);
                }

                $imagesArray = [];
                foreach ($request->file('images') as $img) {
                    $imagesArray[] = $img->store('uploads', 'public');
                }
                $data['images'] = $imagesArray;
            }

            $ad->update($data);
            $ad->images = collect($ad->images)->map(fn($img) => Storage::url($img));

            return response()->json([
                'status'  => 'success',
                'message' => 'Ad updated successfully (replace)',
                'ad'      => $ad,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

// ✅ تعديل إعلان (دمج الصور)
public function updateMerge(Request $request, $id)
{
    try {
        $user = Auth::user();
        $ad   = Ad::find($id);

        if (!$ad) {
            return response()->json(['error' => 'Ad not found'], 404);
        }
        if ($ad->user_id !== $user->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price'       => 'sometimes|numeric',
            'city'        => 'sometimes|string|max:255',
            'category'    => 'sometimes|string|max:255',
            'lat'         => 'nullable|numeric',
            'lng'         => 'nullable|numeric',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $request->only(['title','description','price','city','category','lat','lng','is_featured']);

        // 🟡 تسجيل البيانات القادمة من الطلب للتدقيق
        \Log::info("UpdateMerge Request Data", [
    'all'       => $request->all(),
    'title'     => $request->input('title'),
    'price'     => $request->input('price'),
    'city'      => $request->input('city'),
    'category'  => $request->input('category'),
    'files'     => $request->files->all(),
]);

        $imagesArray = $ad->images ?? [];

        if ($request->hasFile('images')) {
            $files = is_array($request->file('images')) ? $request->file('images') : [$request->file('images')];
            foreach ($files as $img) {
                $imagesArray[] = $img->store('uploads', 'public');
            }
        } elseif ($request->filled('images')) {
            $decoded = json_decode($request->images, true);
            if (is_array($decoded)) $imagesArray = array_merge($imagesArray, $decoded);
        }

        $data['images'] = $imagesArray;
        $ad->update($data);

        $ad->images = collect($ad->images)->map(fn($img) => Storage::url($img));

        return response()->json([
            'status'  => 'success',
            'message' => 'Ad updated successfully (merge)',
            'ad'      => $ad,
        ]);
    } catch (\Throwable $e) {
        \Log::error('Ad Merge Error: '.$e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}

    // ✅ حذف إعلان
    public function destroy($id)
    {
        $user = Auth::user();
        $ad   = Ad::find($id);

        if (!$ad) {
            return response()->json(['error' => 'Ad not found'], 404);
        }
        if ($ad->user_id !== $user->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        foreach ($ad->images ?? [] as $old) {
            Storage::disk('public')->delete($old);
        }

        $ad->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Ad deleted successfully',
        ]);
    }
}

