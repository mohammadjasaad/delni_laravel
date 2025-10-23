<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\MallBanner; // ✅ استدعاء موديل بانرات المول
use Illuminate\Http\Request;

class MallController extends Controller
{
    // 🏬 عرض جميع المتاجر + بانرات المول
    public function index(Request $request)
    {
        $query = Store::query();

        // ✅ فلترة حسب التصنيف
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // ✅ جلب المتاجر (12 بالصفحة)
        $stores = $query->orderBy('created_at', 'desc')->paginate(12);

        // ✅ جلب بانرات المول (أحدث 5 بانرات مثلاً)
$banners = MallBanner::latest()->take(5)->get();
return view('mall.index', compact('stores', 'banners'));

    }

    // ➕ صفحة إنشاء متجر
    public function create()
    {
        return view('mall.create');
    }

    // 💾 حفظ متجر جديد
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $logoPath = $request->file('logo')
            ? $request->file('logo')->store('stores', 'public')
            : null;

        Store::create([
            'name'        => $request->name,
            'category'    => $request->category,
            'description' => $request->description,
            'logo'        => $logoPath,
            'user_id'     => auth()->id(),
            'status'      => 1,
        ]);

        return redirect()->route('mall.index')
                         ->with('success', __('messages.store_added_success'));
    }

    // 👁️ عرض تفاصيل متجر + منتجات + إعلانات مع فلترة وترتيب
    public function show(Store $store, Request $request)
    {
        // 🎯 فلترة المنتجات
        $productsQuery = $store->products()->newQuery();
        if ($request->filled('product_sort')) {
            switch ($request->product_sort) {
                case 'latest':
                    $productsQuery->orderBy('created_at', 'desc');
                    break;
                case 'price_low':
                    $productsQuery->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $productsQuery->orderBy('price', 'desc');
                    break;
            }
        }
        $products = $productsQuery->paginate(8, ['*'], 'products_page');

        // 🎯 فلترة الإعلانات
        $adsQuery = $store->ads()->newQuery();
        if ($request->filled('ad_sort')) {
            switch ($request->ad_sort) {
                case 'latest':
                    $adsQuery->orderBy('created_at', 'desc');
                    break;
                case 'price_low':
                    $adsQuery->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $adsQuery->orderBy('price', 'desc');
                    break;
                case 'featured':
                    $adsQuery->where('is_featured', 1)->orderBy('created_at', 'desc');
                    break;
            }
        }
        $ads = $adsQuery->paginate(6, ['*'], 'ads_page');

        return view('mall.show', compact('store', 'products', 'ads'));
    }
}
