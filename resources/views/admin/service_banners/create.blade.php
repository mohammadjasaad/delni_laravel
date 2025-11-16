{{-- resources/views/admin/service_banners/create.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 dark:text-white mb-6">
            ➕ إضافة بانر جديد للخدمات
        </h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif>

        <form action="{{ route('service-banners.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6 space-y-4">
            @csrf

            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">عنوان البانر</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-gray-100">
            </div>

            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">الرابط (اختياري)</label>
                <input type="text" name="link" value="{{ old('link') }}"
                       class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-gray-100" placeholder="https://...">
            </div>

            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">صورة البانر (مطلوبة)</label>
                <input type="file" name="image_desktop" accept="image/*"
                       class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-gray-100">
                <p class="text-xs text-gray-500 mt-1">المقاس المقترح: عرض كبير أفقي (مثل 1600×500).</p>
            </div>

            <div class="flex items-center gap-3">
                <button class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded">حفظ 💾</button>
                <a href="{{ route('service-banners.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">↩️ رجوع</a>
            </div>
        </form>
    </div>
</x-app-layout>
