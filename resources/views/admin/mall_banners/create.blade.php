<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">➕ إضافة بانر جديد للمول</h1>

        <form action="{{ route('mall-banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <x-label for="title" value="عنوان البانر" />
                <x-input id="title" name="title" type="text" class="w-full mt-2" value="{{ old('title') }}" />
            </div>

            <div>
                <x-label for="link" value="الرابط (اختياري)" />
                <x-input id="link" name="link" type="text" class="w-full mt-2" value="{{ old('link') }}" />
            </div>

            <div>
                <x-label for="image" value="صورة البانر" />
                <input type="file" name="image" id="image" 
                       class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('mall-banners.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">⬅️ رجوع</a>
                <button type="submit" class="px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-500">💾 حفظ</button>
            </div>
        </form>
    </div>
</x-app-layout>
