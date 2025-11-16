<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 🛒 عرض كل المنتجات لمتجر محدد
    public function index(Store $store)
    {
        $products = $store->products()->latest()->paginate(12);
        return view('products.index', compact('store', 'products'));
    }

    // ➕ صفحة إضافة منتج جديد
public function create(Store $store)
{
return view('products.create', compact('store'));
}

    // 💾 حفظ منتج جديد (صور متعددة)
    public function store(Request $request, Store $store)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $images[] = $img->store('products', 'public');
            }
        }

        $store->products()->create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'images'      => $images, // ✅ JSON array
            'status'      => 1,
        ]);

return redirect()->route('mall.show', $store->id)
                 ->with('success', __('messages.product_added_success'));
    }

// 👁️ عرض منتج مفرد + منتجات مشابهة
public function show(Store $store, Product $product)
{
    if ($product->store_id !== $store->id) {
        abort(404);
    }

    // ✅ جلب منتجات مشابهة من نفس المتجر (بدون المنتج الحالي)
    $relatedProducts = $store->products()
        ->where('id', '!=', $product->id)
        ->latest()
        ->take(4)
        ->get();

    return view('products.show', compact('store', 'product', 'relatedProducts'));
}

    // ✏️ تعديل منتج
    public function edit(Store $store, Product $product)
    {
        if ($product->store_id !== $store->id) {
            abort(404);
        }
        return view('products.edit', compact('store', 'product'));
    }

    // 🔄 تحديث منتج (تحديث الصور + الإضافة عليها)
    public function update(Request $request, Store $store, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $existingImages = $product->images ?? [];

        // ✅ إذا رفع صور جديدة → أضفها إلى القائمة
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $existingImages[] = $img->store('products', 'public');
            }
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'images'      => $existingImages,
        ]);

return redirect()->route('mall.show', $store->id)
                 ->with('success', __('messages.product_updated_success'));
    }

    // 🗑️ حذف منتج
    public function destroy(Store $store, Product $product)
    {
        if ($product->store_id !== $store->id) {
            abort(404);
        }

        $product->delete();
        return redirect()->route('mall.products.index', $store->id)
                         ->with('success', __('messages.product_deleted_success'));
    }
}
