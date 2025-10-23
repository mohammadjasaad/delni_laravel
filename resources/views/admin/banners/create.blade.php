{{-- resources/views/admin/banners/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'إضافة بانر جديد')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">➕ إضافة بانر جديد</h1>

    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block mb-2 font-semibold">العنوان</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-2 font-semibold">صورة سطح المكتب</label>
            <input type="file" name="image_desktop" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-2 font-semibold">صورة الموبايل (اختياري)</label>
            <input type="file" name="image_mobile" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-2 font-semibold">الرابط (اختياري)</label>
            <input type="url" name="link" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="active" value="1" class="rounded">
            <label>تفعيل البانر</label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-yellow">💾 حفظ</button>
            <a href="{{ route('banners.index') }}" class="btn-gray">⬅️ رجوع</a>
        </div>
    </form>
</div>
@endsection

