{{-- resources/views/admin/banners/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'إدارة البانرات')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">📢 إدارة البانرات</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('banners.create') }}" class="btn-yellow">
            ➕ إضافة بانر جديد
        </a>
    </div>

    <table class="w-full border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
        <thead class="bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
            <tr>
                <th class="p-3 text-left">#</th>
                <th class="p-3">الصورة</th>
                <th class="p-3">العنوان</th>
                <th class="p-3">الرابط</th>
                <th class="p-3">الحالة</th>
                <th class="p-3">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($banners as $banner)
                <tr class="border-t dark:border-gray-700">
                    <td class="p-3">{{ $banner->id }}</td>
                    <td class="p-3">
                        <img src="{{ asset('storage/'.$banner->image_desktop) }}" class="h-16 rounded shadow">
                    </td>
                    <td class="p-3">{{ $banner->title }}</td>
                    <td class="p-3">
                        @if($banner->link)
                            <a href="{{ $banner->link }}" target="_blank" class="text-blue-600 underline">فتح الرابط</a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="p-3">
                        @if($banner->active)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded">مفعل</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded">غير مفعل</span>
                        @endif
                    </td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('banners.edit', $banner->id) }}" class="btn-gray">✏️ تعديل</a>
                        <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-red">🗑️ حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-6 text-gray-500">لا يوجد بانرات حالياً</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $banners->links() }}
    </div>
</div>
@endsection

