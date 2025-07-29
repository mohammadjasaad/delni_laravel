<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">إعلاناتي</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($ads as $ad)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold mb-2">{{ $ad->title }}</h2>
                        <p class="text-gray-700 text-sm mb-2">{{ $ad->description }}</p>
                        <p class="text-sm"><strong>السعر:</strong> {{ number_format($ad->price) }} ليرة</p>
                        <p class="text-sm"><strong>المدينة:</strong> {{ $ad->city }}</p>
                    </div>
                    <div class="flex justify-between items-center px-4 pb-4">
                        <a href="{{ route('dashboard.ads.edit', $ad->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-4 py-2 rounded">
                            تعديل الإعلان
                        </a>
                        <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الإعلان؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded">
                                حذف
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
