<?php

namespace App\Http\Controllers;

use App\Models\ServiceRating;
use Illuminate\Http\Request;

class ServiceRatingController extends Controller
{
    public function store(Request $request)
    {
        // ✅ التأكد من تسجيل الدخول (لأننا أضفنا middleware مسبقاً)
        $user = auth()->user();

        // ✅ تحقق من البيانات
        $request->validate([
            'subcategory' => 'required|string',
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // ✅ منع تكرار التقييم لنفس الخدمة من نفس المستخدم
        $existing = ServiceRating::where('subcategory', $request->subcategory)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'لقد قمت بإضافة تقييم لهذه الخدمة سابقاً ✅');
        }

        // ✅ حفظ التقييم الجديد
        ServiceRating::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'subcategory' => $request->subcategory,
            'stars' => $request->stars,
            'comment' => $request->comment,
        ]);

        return back()->with('success', '✅ تم إرسال تقييمك بنجاح!');
    }

public function update(Request $request)
{
    $request->validate([
        'id' => 'required|exists:service_ratings,id',
        'stars' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    $rating = ServiceRating::where('id', $request->id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $rating->update([
        'stars' => $request->stars,
        'comment' => $request->comment,
    ]);

    return back()->with('success', '✅ تم تعديل تقييمك بنجاح');
}
}
