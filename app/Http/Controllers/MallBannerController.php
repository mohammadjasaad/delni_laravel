<?php

namespace App\Http\Controllers;

use App\Models\MallBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MallBannerController extends Controller
{
    // 📄 قائمة البانرات
    public function index()
    {
        $banners = MallBanner::latest()->paginate(10);
        return view('admin.mall_banners.index', compact('banners'));
    }

    // ➕ إنشاء جديد
    public function create()
    {
        return view('admin.mall_banners.create');
    }

    // 💾 تخزين جديد
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'link'  => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $path = $request->file('image')->store('mall_banners', 'public');

        MallBanner::create([
            'title' => $request->title,
            'link'  => $request->link,
            'image_desktop' => $path,
        ]);

        return redirect()->route('mall-banners.index')
                         ->with('success', __('messages.banner_added_success'));
    }

    // ✏️ تعديل
    public function edit(MallBanner $mallBanner)
    {
        return view('admin.mall_banners.edit', compact('mallBanner'));
    }

    // 🔄 تحديث
    public function update(Request $request, MallBanner $mallBanner)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'link'  => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $data = $request->only(['title','link']);

        if ($request->hasFile('image')) {
            if ($mallBanner->image_desktop && Storage::disk('public')->exists($mallBanner->image_desktop)) {
                Storage::disk('public')->delete($mallBanner->image_desktop);
            }
            $data['image_desktop'] = $request->file('image')->store('mall_banners', 'public');
        }

        $mallBanner->update($data);

        return redirect()->route('mall-banners.index')
                         ->with('success', __('messages.banner_updated_success'));
    }

    // 🗑️ حذف
    public function destroy(MallBanner $mallBanner)
    {
        if ($mallBanner->image_desktop && Storage::disk('public')->exists($mallBanner->image_desktop)) {
            Storage::disk('public')->delete($mallBanner->image_desktop);
        }
        $mallBanner->delete();

        return redirect()->route('mall-banners.index')
                         ->with('success', __('messages.banner_deleted_success'));
    }
}
