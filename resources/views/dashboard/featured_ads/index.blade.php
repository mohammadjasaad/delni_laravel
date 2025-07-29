<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-yellow-600 text-center mb-8">⭐ الإعلانات المميزة</h1>

        @if ($ads->isEmpty())
            <div class="bg-white p-6 rounded shadow text-center text-gray-600">
                لا توجد إعلانات مميزة حالياً.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($ads as $ad)
                    <div class="bg-white rounded shadow p-4 border border-yellow-400">
                        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $ad->title }}</h2>
                        <p class="text-gray-600 mb-1">🏷️ {{ $ad->category }}</p>
                        <p class="text-gray-600 mb-1">🏙️ {{ $ad->city }}</p>
                        <p class="text-gray-700 font-semibold mb-2">💰 {{ $ad->price }} ل.س</p>
                        <a href="{{ route('ads.show', $ad->id) }}"
                           class="text-yellow-600 hover:underline text-sm">عرض التفاصيل</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
