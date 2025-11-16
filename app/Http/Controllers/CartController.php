<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 🛒 عرض السلة
public function index()
{
    $items = CartItem::where('user_id', auth()->id())->with('product')->get();
    $total = $items->sum(function($item){
        return $item->product->price * $item->quantity;
    });

    return view('cart.index', compact('items', 'total'));
}

    // ➕ إضافة للسلة
// ➕ إضافة للسلة
public function add(Request $request, \App\Models\Store $store, Product $product)
{
    $item = CartItem::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->where('store_id', $store->id)
        ->first();

    if ($item) {
        $item->quantity += 1;
        $item->save();
    } else {
        CartItem::create([
            'user_id'    => auth()->id(),
            'store_id'   => $store->id,
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);
    }

    return back()->with('success', '✅ تم إضافة المنتج إلى السلة بنجاح');
}

// زيادة الكمية
public function increase(CartItem $item)
{
    $item->quantity += 1;
    $item->save();

    return back();
}

// تقليل الكمية
public function decrease(CartItem $item)
{
    if ($item->quantity > 1) {
        $item->quantity -= 1;
        $item->save();
    } else {
        $item->delete(); // إذا وصل 0 نحذفه
    }

    return back();
}

    // ❌ حذف عنصر من السلة
    public function remove(CartItem $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        $item->delete();
        return back()->with('success', '🗑️ تم حذف المنتج من السلة');
    }
}
