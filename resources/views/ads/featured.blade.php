<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-yellow-600 text-center mb-10">⭐ الإعلانات المميزة</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($ads as $ad)
                <div class="bg-white rounded shadow p-4">
                    <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-48 object-cover rounded mb-4">
                    <h2 class="text-lg font-semibold mb-2">{{ $ad->title }}</h2>
                    <p class="text-gray-600 mb-2">{{ $ad->city }} - {{ $ad->category }}</p>
                    <p class="text-yellow-600 font-bold mb-2">{{ number_format($ad->price) }} ل.س</p>
                    <a href="{{ route('ads.show', $ad->id) }}" class="text-sm text-blue-600 hover:underline">عرض التفاصيل</a>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-600">لا توجد إعلانات مميزة حالياً.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
