<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdController extends Controller
{

// 📄 عرض جميع الإعلانات
public function index(Request $request)
{
    $query = Ad::query();

    // 🌍 فلترة المدينة
    if ($request->filled('city')) {
        $query->where('city', $request->city);
    }

    // 📂 فلترة التصنيف
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // ⭐ فلترة حالة الإعلان
    if ($request->filled('featured')) {
        $query->where('is_featured', $request->featured);
    }

    // 💰 فلترة السعر
    if ($request->filled('price_min')) $query->where('price', '>=', $request->price_min);
    if ($request->filled('price_max')) $query->where('price', '<=', $request->price_max);

    // 🏠 عقارات
    if ($request->category === 'realestate') {
        if ($request->filled('subcategory')) $query->where('subcategory', $request->subcategory);
        if ($request->filled('deal_type')) $query->where('deal_type', $request->deal_type);
        if ($request->filled('rooms')) $query->where('rooms', $request->rooms);
        if ($request->filled('building_age')) $query->where('building_age', '<=', $request->building_age);
        if ($request->filled('area_min')) $query->where('area', '>=', $request->area_min);
        if ($request->filled('area_max')) $query->where('area', '<=', $request->area_max);
    }

    // 🚗 سيارات
    if ($request->category === 'cars') {
        if ($request->filled('car_brand')) $query->where('car_brand', $request->car_brand);
        if ($request->filled('car_year')) $query->where('car_year', $request->car_year);
        if ($request->filled('fuel')) $query->where('fuel', $request->fuel);
        if ($request->filled('gearbox')) $query->where('gearbox', $request->gearbox);
        if ($request->filled('car_color')) $query->where('car_color', $request->car_color);
        if ($request->filled('car_km_max')) $query->where('car_km', '<=', $request->car_km_max);
    }

    // 🛠️ خدمات
    if ($request->category === 'services') {
        if ($request->filled('service_type')) $query->where('service_type', $request->service_type);
        if ($request->filled('provider_name')) $query->where('provider_name', 'like', "%{$request->provider_name}%");
    }

    // 🔄 الترتيب
    switch ($request->get('sort')) {
        case 'price_asc':
            $query->orderBy('is_featured', 'desc')->orderBy('price', 'asc');
            break;
        case 'price_desc':
            $query->orderBy('is_featured', 'desc')->orderBy('price', 'desc');
            break;
        default:
            $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
            break;
    }

    // ✅ 12 إعلان كل مرة
    $ads = $query->paginate(12);

    // إذا الطلب AJAX ➝ رجّع جزء البطاقات فقط
    if ($request->ajax()) {
        return view('ads.partials.list', compact('ads'))->render();
    }

    // إذا الطلب عادي ➝ رجّع الصفحة الكاملة
    return view('ads.index', compact('ads'));
}

    // ➕ إنشاء إعلان
    public function create()
    {
        $cities = ['دمشق','حلب','حمص','اللاذقية','حماة','طرطوس','درعا','دير الزور','الرقة','إدلب','الحسكة','السويداء'];
        $categories = ['عقار','سيارة','خدمة','أخرى'];
        return view('ads.create', compact('cities','categories'));
    }

    // 💾 حفظ إعلان جديد
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'city'        => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('uploads', 'public');
            }
        }

        $ad = Ad::create([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'city'        => $request->city,
            'category'    => $request->category,
            'images'      => $images,
            'user_id'     => auth()->id(),
            'lat'         => $request->lat,
            'lng'         => $request->lng,
            'is_featured' => $request->is_featured ?? false,
            'slug'        => Str::slug($request->title) . '-' . uniqid(),
        ]);

        return redirect()->route('ads.show', $ad->slug)
                         ->with('success', __('messages.ad_added_successfully'));
    }

    // 👁️ عرض إعلان (بالـ slug)
    public function show($slug)
    {
        $ad = Ad::where('slug', $slug)->firstOrFail();

        $relatedAds = Ad::where('id', '!=', $ad->id)
                        ->where(fn($q) => $q->where('city', $ad->city)
                                             ->orWhere('category', $ad->category))
                        ->latest()->take(6)->get();

        return view('ads.show', compact('ad','relatedAds'));
    }

    // ✏️ تعديل إعلان
    public function edit($id)
    {
        $ad = Ad::findOrFail($id);
        if ($ad->user_id !== Auth::id()) abort(403, __('messages.access_denied'));
        return view('dashboard.edit', compact('ad'));
    }

    // 🔄 تحديث إعلان
    public function update(Request $request, $id)
    {
        $ad = Ad::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'city'        => 'required|string',
            'category'    => 'required|string',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        // 🖼️ إدارة الصور
        $images = $ad->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($images as $old) {
                Storage::disk('public')->delete($old);
            }
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('uploads', 'public');
            }
        }
        $validated['images'] = $images;

        // ⚡ نحافظ على الـ slug القديم
        $validated['slug'] = $ad->slug;

        $ad->update($validated);

        return redirect()->route('dashboard.myads')
                         ->with('success', __('messages.ad_updated_successfully'));
    }

    // 🗑️ حذف إعلان
    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);
        if ($ad->user_id !== Auth::id()) abort(403, __('messages.access_denied'));
        foreach ($ad->images ?? [] as $old) Storage::disk('public')->delete($old);
        $ad->delete();
        return redirect()->route('dashboard.myads')->with('success', __('messages.ad_deleted_successfully'));
    }

    // ❤️ المفضلة
public function addFavorite($slug)
{
    $user = Auth::user();
    $ad   = Ad::where('slug', $slug)->firstOrFail();

    if (!$user->favorites()->where('ad_id',$ad->id)->exists()) {
        $user->favorites()->create(['ad_id'=>$ad->id]);
    }

    return back()->with('success', __('messages.add_to_favorite_success'));
}

public function removeFavorite($slug)
{
    $user = Auth::user();
    $ad   = Ad::where('slug', $slug)->firstOrFail();

    $user->favorites()->where('ad_id',$ad->id)->delete();

    return back()->with('success', __('messages.remove_favorite_success'));
}

    // ⭐ التمييز
    public function makeFeatured($id)
    {
        $ad = Ad::findOrFail($id);
        if ($ad->user_id !== auth()->id()) abort(403);
        $ad->is_featured = 1;
        $ad->save();
        return back()->with('success', __('messages.feature_ad_success'));
    }

    public function removeFeatured($id)
    {
        $ad = Ad::findOrFail($id);
        if ($ad->user_id !== auth()->id()) abort(403);
        $ad->is_featured = 0;
        $ad->save();
        return back()->with('success', __('messages.unfeature_ad_success'));
    }

    // 🟡 إعلاناتي
    public function myAds(Request $request)
    {
        $query = Ad::where('user_id', auth()->id());

        if ($request->filled('city')) $query->where('city', $request->city);
        if ($request->filled('category')) $query->where('category', $request->category);
        if ($request->filled('featured')) $query->where('is_featured', $request->featured);

        switch ($request->get('sort')) {
            case 'price_asc':
                $query->orderBy('is_featured', 'desc')->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('is_featured', 'desc')->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                break;
        }

        $ads = $query->paginate(12)->appends($request->query());

        // ✅ عدادات
        $totalCount    = Ad::where('user_id', auth()->id())->count();
        $featuredCount = Ad::where('user_id', auth()->id())->where('is_featured', 1)->count();
        $normalCount   = Ad::where('user_id', auth()->id())->where('is_featured', 0)->count();

        return view('dashboard.myads', compact('ads', 'totalCount', 'featuredCount', 'normalCount'));
    }

    // 🗺️ بيانات الخريطة
    public function mapData()
    {
        $ads = Ad::select('id', 'title', 'price', 'city', 'lat', 'lng', 'images', 'slug')
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->get()
            ->map(function ($ad) {
                $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                if (!$images || count($images) === 0) {
                    $images = ['placeholder.png'];
                }

                return [
                    'id'          => $ad->id,
                    'title'       => $ad->title,
                    'price'       => $ad->price,
                    'city'        => $ad->city,
                    'lat'         => $ad->lat,
                    'lng'         => $ad->lng,
                    'images'      => $images,
                    'first_image' => asset('storage/' . $images[0]),
                    'url'         => route('ads.show', $ad->slug),
                ];
            });

        return response()->json($ads);
    }
}
