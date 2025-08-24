<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Driver; // ✅ نستخدم Driver لأنه الموجود عندك

class RatingController extends Controller
{
    /**
     * حفظ تقييم السائق
     * يدعم:
     * - طلبات JSON (fetch/AJAX) من الواجهة
     * - فورم عادي (redirect مع رسالة نجاح)
     */
    public function store(Request $request)
    {
        // ✅ تحقّق مرن: driver_id اختياري، وإن وُجد نتحقّق أنه في جدول drivers
        $validated = $request->validate([
            'driver_id'   => 'nullable|exists:drivers,id',
            'driver_name' => 'nullable|string|max:255',
            'rating'      => 'required|numeric|min:1|max:5',
            'comment'     => 'nullable|string|max:1000',
            'order_id'    => 'nullable|exists:taxi_orders,id',
        ]);

        // ✅ لو ما جاء اسم السائق لكن فيه driver_id: نجيبه تلقائيًا من Driver
        if (empty($validated['driver_name']) && !empty($validated['driver_id'])) {
            $drv = Driver::find($validated['driver_id']);
            if ($drv) {
                $validated['driver_name'] = $drv->name;
            }
        }

        // ✅ تجهيز الحقول للحفظ (ندعم وجود أعمدة driver_id / order_id لو موجودة في الجدول)
$payload = [
    'driver_id'   => $validated['driver_id']   ?? null,
    'order_id'    => $validated['order_id']    ?? null,
    'driver_name' => $validated['driver_name'] ?? 'غير معروف',
    'rating'      => (float) $validated['rating'],
    'stars'       => (int) $validated['rating'], // ✅ نعبّيها بنفس قيمة rating
    'comment'     => $validated['comment']     ?? null,
];

        $rating = Rating::create($payload);

        // ✅ نرجّع JSON إن كان الطلب AJAX/JSON، وإلا نعيد توجيه مع فلاش
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status'  => true,
                'message' => 'تم حفظ التقييم بنجاح',
                'rating'  => $rating,
            ], 201);
        }

        return back()->with('success', 'تم حفظ التقييم بنجاح');
    }
}
