<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    // ----------------- 🏠 الصفحة الرئيسية -----------------
    public function home(Request $request)
    {
        $query = Ad::query();

        if ($request->has('filter')) {
            $query->where('category', $request->filter);
        }

        if ($request->filled('city')) {
            $query->where('city', 'LIKE', '%' . $request->city . '%');
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $ads = $query->latest()->get();

        return view('home', compact('ads'));
    }

    // ----------------- 📄 صفحة عرض كل الإعلانات -----------------
public function index(Request $request)
{
    $query = Ad::query();

    // 🔍 فلترة بالكلمة المفتاحية (بحث عام)
    if ($request->filled('q')) {
        $query->where(function ($subquery) use ($request) {
            $subquery->where('title', 'like', '%' . $request->q . '%')
                     ->orWhere('description', 'like', '%' . $request->q . '%')
                     ->orWhere('city', 'like', '%' . $request->q . '%')
                     ->orWhere('category', 'like', '%' . $request->q . '%');
        });
    }

    // 🔎 فلترة حسب المدينة
    if ($request->filled('city')) {
        $query->where('city', $request->city);
    }

    // 🔎 فلترة حسب التصنيف
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // 💰 فلترة حسب السعر
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    // 🌟 فلترة الإعلانات المميزة فقط
    if ($request->filled('is_featured')) {
        $query->where('is_featured', $request->is_featured);
    }

    // 📄 جلب الإعلانات مع ترتيبها الأحدث أولًا
    $ads = $query->latest()->paginate(12);

    return view('ads.index', compact('ads'));
}

    // ----------------- ➕ صفحة إنشاء إعلان -----------------
public function create()
{
    $cities = ['دمشق', 'حلب', 'حمص', 'اللاذقية', 'حماة', 'طرطوس', 'درعا', 'دير الزور', 'الرقة', 'إدلب', 'الحسكة', 'السويداء'];
    $categories = ['عقار', 'سيارة', 'خدمة', 'أخرى'];

    return view('ads.create', compact('cities', 'categories'));
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'city' => 'required|string',
        'category' => 'required|string',
        'lat' => 'nullable|numeric',
        'lng' => 'nullable|numeric',
        'images.*' => 'image|max:10240',
    ]);

    $imagePaths = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $filename);
            $imagePaths[] = 'uploads/' . $filename;
        }
    }

    Ad::create([
        'user_id'    => auth()->id(),
        'title'      => $request->title,
        'description'=> $request->description,
        'price'      => $request->price,
        'city'       => $request->city,
        'category'   => $request->category,
        'lat'        => $request->lat,
        'lng'        => $request->lng,
        'images'     => json_encode($imagePaths, JSON_UNESCAPED_UNICODE),
    ]);

    return redirect()->route('dashboard.myads')->with('success', '✅ تم نشر الإعلان بنجاح.');
}

    // ----------------- 👁️‍🗨️ صفحة عرض إعلان -----------------
public function show($id)
{
    $ad = Ad::findOrFail($id);

    $relatedAds = Ad::where('id', '!=', $id)
        ->where(function ($query) use ($ad) {
            $query->where('city', $ad->city)
                  ->orWhere('category', $ad->category);
        })
        ->latest()
        ->take(6)
        ->get();

    return view('ads.show', compact('ad', 'relatedAds'));
}

    // ----------------- ✏️ تعديل إعلان -----------------
    public function edit($id)
    {
        $ad = Ad::findOrFail($id);

        if ($ad->user_id !== Auth::id()) {
            abort(403, 'ليس لديك صلاحية لتعديل هذا الإعلان.');
        }

        return view('dashboard.edit', compact('ad'));
    }

    public function update(Request $request, $id)
    {
        $ad = Ad::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'city' => 'required|string',
            'category' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('images')) {
            $oldImages = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
            foreach ($oldImages as $old) {
                if (file_exists(public_path($old))) {
                    @unlink(public_path($old));
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $imageName);
                $imagePaths[] = 'uploads/' . $imageName;
            }

            $validated['images'] = json_encode($imagePaths, JSON_UNESCAPED_UNICODE);
        }

        $ad->update($validated);

        return redirect()->route('dashboard.myads')->with('success', 'تم تحديث الإعلان بنجاح');
    }

    // ----------------- 🗑️ حذف إعلان -----------------
    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);

        if ($ad->user_id !== Auth::id()) {
            abort(403, 'ليس لديك صلاحية لحذف هذا الإعلان.');
        }

        $ad->delete();

        return redirect()->route('dashboard.myads')->with('success', 'تم حذف الإعلان بنجاح.');
    }

    // ----------------- 👤 حساب المستخدم -----------------
    public function myAds()
    {
        $ads = Ad::where('user_id', auth()->id())->get();
        return view('dashboard.myads', compact('ads'));
    }

    public function myInfo()
    {
        return view('dashboard.myinfo');
    }

    // ----------------- ⭐ المفضلة -----------------
    public function addFavorite($id)
    {
        $user = Auth::user();
        $ad = Ad::findOrFail($id);

        if (!$user->favorites()->where('ad_id', $id)->exists()) {
            $user->favorites()->create(['ad_id' => $id]);
        }

        return back()->with('success', 'تمت إضافة الإعلان إلى المفضلة.');
    }

    public function removeFavorite($id)
    {
        $user = Auth::user();
        $user->favorites()->where('ad_id', $id)->delete();

        return back()->with('success', 'تمت إزالة الإعلان من المفضلة.');
    }

    public function favorites()
    {
        $user = auth()->user();
        $ads = $user->favorites()->with('ad')->get()->pluck('ad');

        return view('dashboard.favorites', compact('ads'));
    }
public function toggleFeatured($id)
{
    $ad = Ad::findOrFail($id);
    $ad->is_featured = !$ad->is_featured;
    $ad->save();

    return redirect()->back()->with('success', 'تم تحديث حالة التمييز بنجاح.');
}
// ✅ اجعل الإعلان مميز
public function makeFeatured($id)
{
    $ad = Ad::findOrFail($id);

    // تأكد أن الإعلان يخص المستخدم الحالي (اختياري للحماية)
    if ($ad->user_id !== auth()->id()) {
        abort(403, 'غير مصرح لك.');
    }

    $ad->is_featured = 1;
    $ad->save();

    return back()->with('success', '✅ تم تمييز الإعلان بنجاح.');
}

// ✅ إزالة التمييز عن الإعلان
public function removeFeatured($id)
{
    $ad = Ad::findOrFail($id);

    // تأكد أن الإعلان يخص المستخدم الحالي
    if ($ad->user_id !== auth()->id()) {
        abort(403, 'غير مصرح لك.');
    }

    $ad->is_featured = 0;
    $ad->save();

    return back()->with('success', '❌ تم إزالة التمييز من الإعلان.');
}
public function feature($id)
{
    $ad = Ad::findOrFail($id);
    if ($ad->user_id == auth()->id()) {
        $ad->is_featured = 1;
        $ad->save();
        return back()->with('success', 'تم تمييز الإعلان بنجاح');
    }
    return back()->with('error', 'لا تملك صلاحية لتعديل هذا الإعلان');
}

public function unfeature($id)
{
    $ad = Ad::findOrFail($id);
    if ($ad->user_id == auth()->id()) {
        $ad->is_featured = 0;
        $ad->save();
        return back()->with('success', 'تم إزالة التمييز عن الإعلان');
    }
    return back()->with('error', 'لا تملك صلاحية لتعديل هذا الإعلان');
}

}
