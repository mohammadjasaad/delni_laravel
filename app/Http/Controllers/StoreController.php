<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    // 🏬 لوحة تحكم المتجر
    public function dashboard(Store $store)
    {
        return view('mall.dashboard', compact('store'));
    }

    // ✏️ صفحة تعديل المتجر
    public function edit(Store $store)
    {
        return view('mall.edit', compact('store'));
    }

    // 💾 حفظ التعديلات
    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        $store->update([
            'name'        => $request->name,
            'category'    => $request->category,
            'description' => $request->description,
        ]);

        return redirect()->route('mall.dashboard', $store->id)
                         ->with('success', __('messages.store_updated_success'));
    }

    // 🗑️ حذف متجر (معدل لدعم أكثر من رسالة)
    public function destroy(Store $store)
    {
        // ✅ تحقق أن المستخدم الحالي هو المالك
        if (auth()->id() !== $store->user_id) {
            abort(403, 'غير مسموح لك بحذف هذا المتجر');
        }

        // ✅ حذف المتجر
        $store->delete();

        // ✅ إعادة التوجيه مع رسائل متعددة
        return redirect()->route('mall.index')
            ->with('success', ['تم الحذف بنجاح ✅', 'تم تحديث القائمة'])
            ->with('warning', ['تأكد من إدخال كل الحقول', 'بعض البيانات ناقصة']);
    }

    // 📢 حفظ إعلان جديد مرتبط بالمتجر
    public function storeAd(Request $request, Store $store)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric',
            'city'        => 'nullable|string|max:100',
            'category'    => 'required|string|max:100',
            'images.*'    => 'nullable|image|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('ads', 'public');
            }
        }

        Ad::create([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'city'        => $request->city,
            'category'    => $request->category,
            'images'      => $images,
            'user_id'     => Auth::id(),
            'store_id'    => $store->id,
            'is_featured' => $request->boolean('is_featured'),
            'is_urgent'   => $request->boolean('is_urgent'),
            'type'        => $request->input('type', 'offer'),
        ]);

        return redirect()->route('mall.dashboard', $store->id)
                         ->with('success', __('messages.ad_created_success'));
    }

    // 📄 صفحة إضافة إعلان جديد للمتجر
    public function createAd(Store $store)
    {
        return view('mall.create-ad', compact('store'));
    }

    // 📄 عرض جميع إعلانات المتجر
    public function ads(Store $store)
    {
        $ads = $store->ads()->orderBy('created_at', 'desc')->paginate(12);
        return view('mall.ads-index', compact('store', 'ads'));
    }

    // 👁️ عرض إعلان مفرد
    public function showAd(Store $store, Ad $ad)
    {
        if ($ad->store_id !== $store->id) {
            abort(404);
        }
        return view('mall.show-ad', compact('store', 'ad'));
    }

    // ✏️ تعديل إعلان
    public function editAd(Store $store, Ad $ad)
    {
        if ($ad->store_id !== $store->id) {
            abort(404);
        }
        return view('mall.edit-ad', compact('store', 'ad'));
    }

    // 🔄 تحديث إعلان
    public function updateAd(Request $request, Store $store, Ad $ad)
    {
        if ($ad->store_id !== $store->id) {
            abort(404);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric',
            'city'        => 'nullable|string|max:100',
            'category'    => 'required|string|max:100',
            'images.*'    => 'nullable|image|max:2048',
        ]);

        $images = $ad->images ?? [];
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('ads', 'public');
            }
        }

        $ad->update([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'city'        => $request->city,
            'category'    => $request->category,
            'images'      => $images,
            'is_featured' => $request->boolean('is_featured'),
            'is_urgent'   => $request->boolean('is_urgent'),
            'type'        => $request->input('type', 'offer'),
        ]);

        return redirect()->route('mall.ads.index', $store->id)
                         ->with('success', __('messages.ad_updated_success'));
    }

    // 🗑️ حذف إعلان
    public function destroyAd(Store $store, Ad $ad)
    {
        if ($ad->store_id !== $store->id) {
            abort(404);
        }

        $ad->delete();

        return redirect()->route('mall.ads.index', $store->id)
                         ->with('success', __('messages.ad_deleted_success'));
    }
}
