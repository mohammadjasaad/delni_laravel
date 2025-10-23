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

    // 💾 حفظ منتج جديد
    public function store(Request $request, Store $store)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = $request->file('image')
            ? $request->file('image')->store('products', 'public')
            : null;

        $store->products()->create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'image'       => $imagePath,
            'status'      => 1,
        ]);

        return redirect()->route('mall.products.index', $store->id)
                         ->with('success', __('messages.product_added_success'));
    }

    // 👁️ عرض منتج مفرد
    public function show(Store $store, Product $product)
    {
        if ($product->store_id !== $store->id) {
            abort(404);
        }
        return view('products.show', compact('store', 'product'));
    }

    // ✏️ تعديل منتج
    public function edit(Store $store, Product $product)
    {
        if ($product->store_id !== $store->id) {
            abort(404);
        }
        return view('products.edit', compact('store', 'product'));
    }

    // 🔄 تحديث منتج
    public function update(Request $request, Store $store, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'image'       => $imagePath,
        ]);

        return redirect()->route('mall.products.index', $store->id)
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
