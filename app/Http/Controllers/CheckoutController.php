<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // ✅ عرض صفحة الإتمام
    public function index()
    {
        $items = CartItem::where('user_id', auth()->id())->with('product')->get();
        $total = $items->sum(fn($item) => $item->product->price * $item->quantity);

        return view('checkout.index', compact('items', 'total'));
    }

    // ✅ حفظ الطلب بعد التأكيد
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // 1️⃣ إنشاء الطلب
            $order = Order::create([
                'user_id' => auth()->id(),
                'name'    => $request->name,
                'phone'   => $request->phone,
                'address' => $request->address,
                'total'   => $request->total,
                'status'  => 'قيد المعالجة',
            ]);

            // 2️⃣ جلب السلة الحالية
            $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();

            // 3️⃣ حفظ تفاصيل المنتجات ضمن الطلب (اختياري الآن — يمكننا إنشاء جدول order_items لاحقًا)
            foreach ($cartItems as $item) {
                DB::table('order_items')->insert([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 4️⃣ حذف السلة بعد تأكيد الطلب
            CartItem::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('checkout.success', ['id' => $order->id])
                ->with('success', '✅ تم تأكيد الطلب بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء تأكيد الطلب: ' . $e->getMessage());
        }
    }

    // ✅ صفحة النجاح بعد الطلب
    public function success($id)
    {
        $order = Order::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}
