<?php

namespace App\Http\Controllers;

use App\Models\ServiceBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceBannerController extends Controller
{
    public function index()
    {
        $banners = ServiceBanner::latest()->get();
        return view('admin.service_banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.service_banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image_desktop' => 'required|image|max:4096',
            'link' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image_desktop')->store('service_banners', 'public');

        ServiceBanner::create([
            'title' => $request->title,
            'image_desktop' => $path,
            'link' => $request->link,
        ]);

        return redirect()->route('service-banners.index')->with('success', '✅ تم إضافة البانر بنجاح.');
    }

    public function edit(ServiceBanner $serviceBanner)
    {
        return view('admin.service_banners.edit', compact('serviceBanner'));
    }

    public function update(Request $request, ServiceBanner $serviceBanner)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image_desktop' => 'nullable|image|max:4096',
            'link' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['title', 'link']);

        if ($request->hasFile('image_desktop')) {
            Storage::disk('public')->delete($serviceBanner->image_desktop);
            $data['image_desktop'] = $request->file('image_desktop')->store('service_banners', 'public');
        }

        $serviceBanner->update($data);

        return redirect()->route('service-banners.index')->with('success', '✅ تم تحديث البانر بنجاح.');
    }

    public function destroy(ServiceBanner $serviceBanner)
    {
        Storage::disk('public')->delete($serviceBanner->image_desktop);
        $serviceBanner->delete();

        return redirect()->route('service-banners.index')->with('success', '🗑️ تم حذف البانر بنجاح.');
    }
}
