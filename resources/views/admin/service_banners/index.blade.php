{{-- resources/views/admin/service_banners/index.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-6xl mx-auto py-8 px-4">

        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 dark:text-white mb-6">
            🖼️ إدارة بانرات الخدمات
        </h1>

        <div class="mb-6">
            <a href="{{ route('service-banners.create') }}"
               class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-lg">
                <span>➕</span> <span>إضافة بانر جديد</span>
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
        @endif

        @forelse($banners as $banner)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="w-full">
                    <img src="{{ asset('storage/'.$banner->image_desktop) }}"
                         alt="{{ $banner->title ?? 'service banner' }}"
                         class="w-full h-44 md:h-64 object-cover">
                </div>
                <div class="p-4 flex items-center justify-between gap-3">
                    <div>
                        <div class="text-lg font-bold text-gray-800 dark:text-gray-100">
                            {{ $banner->title ?: '— بدون عنوان —' }}
                        </div>
                        @if($banner->link)
                            <div class="text-sm text-blue-600 truncate">{{ $banner->link }}</div>
                        @endif
                        <div class="text-xs text-gray-500 mt-1">#{{ $banner->id }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('service-banners.edit', $banner->id) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1.5 rounded text-sm font-semibold">✏️ تعديل</a>

                        <form action="{{ route('service-banners.destroy', $banner->id) }}" method="POST"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا البانر؟');">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-sm font-semibold">🗑️ حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-yellow-50 text-yellow-800 px-4 py-3 rounded">
                لا توجد بانرات بعد. اضغط “إضافة بانر جديد”.
            </div>
        @endforelse
    </div>
</x-app-layout>
