{{-- resources/views/admin/banners/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'تعديل بانر')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">✏️ تعديل بانر</h1>

    <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-2 font-semibold">العنوان</label>
            <input type="text" name="title" value="{{ $banner->title }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-2 font-semibold">صورة سطح المكتب</label>
            <input type="file" name="image_desktop" class="w-full border rounded px-3 py-2">
            <img src="{{ asset('storage/'.$banner->image_desktop) }}" class="h-24 mt-2 rounded shadow">
        </div>

        <div>
            <label class="block mb-2 font-semibold">صورة الموبايل</label>
            <input type="file" name="image_mobile" class="w-full border rounded px-3 py-2">
            @if($banner->image_mobile)
                <img src="{{ asset('storage/'.$banner->image_mobile) }}" class="h-24 mt-2 rounded shadow">
            @endif
        </div>

        <div>
            <label class="block mb-2 font-semibold">الرابط (اختياري)</label>
            <input type="url" name="link" value="{{ $banner->link }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="active" value="1" {{ $banner->active ? 'checked' : '' }} class="rounded">
            <label>تفعيل البانر</label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-yellow">💾 تحديث</button>
            <a href="{{ route('banners.index') }}" class="btn-gray">⬅️ رجوع</a>
        </div>
    </form>
</div>
@endsection
