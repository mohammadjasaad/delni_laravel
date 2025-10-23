<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    // 📄 عرض جميع البانرات
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    // ➕ إنشاء بانر جديد
    public function create()
    {
        return view('admin.banners.create');
    }

    // 💾 حفظ بانر جديد
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_desktop' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|url',
            'active' => 'boolean',
        ]);

        // رفع الصور
        $desktopPath = $request->file('image_desktop')->store('banners', 'public');
        $mobilePath = $request->hasFile('image_mobile')
            ? $request->file('image_mobile')->store('banners', 'public')
            : null;

        Banner::create([
            'title' => $request->title,
            'image_desktop' => $desktopPath,
            'image_mobile' => $mobilePath,
            'link' => $request->link,
            'active' => $request->active ?? false,
        ]);

        return redirect()->route('banners.index')->with('success', '✅ تم إضافة البانر بنجاح');
    }

    // ✏️ تعديل بانر
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    // 🔄 تحديث بانر
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_desktop' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|url',
            'active' => 'boolean',
        ]);

        $data = $request->only(['title', 'link', 'active']);

        // تحديث الصور لو تم رفع جديد
        if ($request->hasFile('image_desktop')) {
            Storage::disk('public')->delete($banner->image_desktop);
            $data['image_desktop'] = $request->file('image_desktop')->store('banners', 'public');
        }

        if ($request->hasFile('image_mobile')) {
            if ($banner->image_mobile) {
                Storage::disk('public')->delete($banner->image_mobile);
            }
            $data['image_mobile'] = $request->file('image_mobile')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('banners.index')->with('success', '✅ تم تحديث البانر بنجاح');
    }

    // 🗑️ حذف بانر
    public function destroy(Banner $banner)
    {
        Storage::disk('public')->delete([$banner->image_desktop, $banner->image_mobile]);
        $banner->delete();

        return redirect()->route('banners.index')->with('success', '🗑️ تم حذف البانر بنجاح');
    }
}
