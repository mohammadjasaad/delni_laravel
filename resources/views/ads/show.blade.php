{{-- resources/views/ads/show.blade.php --}}
<x-main-layout>
    <div class="max-w-6xl mx-auto px-4 py-10">

        {{-- 🔙 زر الرجوع --}}
        <div class="mb-6">
            <a href="{{ route('ads.index') }}" class="text-yellow-600 hover:underline text-sm">
                ← {{ __('messages.back_to_ads') }}
            </a>
        </div>

        {{-- 🏷️ عنوان الإعلان --}}
        <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-4">{{ $ad->title }}</h1>

        {{-- ⭐ إعلان مميز --}}
        @if($ad->is_featured)
            <div class="text-center mb-6">
                <span class="inline-block bg-yellow-400 text-white font-bold px-4 py-2 rounded-full shadow">
                    ⭐ {{ __('messages.featured_ad') }}
                </span>
            </div>
        @endif

        {{-- 🖼️ صور الإعلان --}}
        @php
            $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
        @endphp

        @if($images && count($images) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                @foreach($images as $image)
                    <img src="{{ asset('storage/' . $image) }}" alt="Ad Image"
                         class="rounded-xl shadow-md h-64 w-full object-cover hover:scale-105 transition duration-300">
                @endforeach
            </div>
        @else
            <img src="/placeholder.png" alt="No Image"
                 class="rounded-xl shadow-md h-64 w-full object-cover mb-6 opacity-60">
        @endif

        {{-- 📋 تفاصيل الإعلان --}}
        <div class="bg-white rounded-2xl shadow-md p-6 grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-gray-700 text-lg">
            <p><strong class="text-gray-900">{{ __('messages.price') }}:</strong>
                <span class="text-yellow-600 font-bold">💰 {{ number_format($ad->price) }} {{ __('messages.currency') }}</span>
            </p>
            <p><strong class="text-gray-900">{{ __('messages.city') }}:</strong> 📍 {{ $ad->city }}</p>
            <p><strong class="text-gray-900">{{ __('messages.category') }}:</strong> 🗂️ {{ $ad->category }}</p>
            <p><strong class="text-gray-900">{{ __('messages.created_at') }}:</strong> ⏰ {{ $ad->created_at->format('Y-m-d H:i') }}</p>
        </div>

        {{-- ❤️ زر المفضلة --}}
        @auth
            <form method="POST" action="{{ route('favorites.store', $ad->id) }}" class="text-center mb-8">
                @csrf
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full shadow-md">
                    ❤️ {{ __('messages.add_to_favorite') }}
                </button>
            </form>
        @endauth

        {{-- 📝 وصف الإعلان --}}
        <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
            <h2 class="text-2xl font-extrabold text-gray-800 mb-4">📝 {{ __('messages.description') }}</h2>
            <p class="text-base text-gray-700 leading-relaxed whitespace-pre-line">{{ $ad->description }}</p>
        </div>

        {{-- 🚨 نموذج الإبلاغ --}}
        <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-red-600 mb-4">🚨 {{ __('messages.report_ad') }}</h2>
            @auth
                <form method="POST" action="{{ route('ads.report', $ad->id) }}">
                    @csrf
                    <textarea name="message" rows="3" class="w-full p-3 border rounded-xl text-sm mb-3"
                              placeholder="{{ __('messages.report_message_placeholder') }}"></textarea>
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2 rounded-lg text-sm shadow">
                        {{ __('messages.submit_report') }}
                    </button>
                </form>
            @else
                <p class="text-sm text-gray-600">{{ __('messages.login_to_report') }}</p>
            @endauth
        </div>

        {{-- 📞 تواصل مع البائع --}}
        <div class="text-center mt-8">
            <a href="https://wa.me/?text={{ urlencode('مرحبا، أنا مهتم بالإعلان: ' . $ad->title . ' على موقع Delni.co. الرابط: ' . url()->current()) }}"
               target="_blank"
               class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full shadow transition">
                📲 {{ __('messages.contact_on_whatsapp') }}
            </a>
        </div>

        {{-- 🗺️ خريطة الموقع --}}
        @if ($ad->lat && $ad->lng)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-yellow-600 mb-4 text-center">📍 {{ __('messages.ad_location') }}</h2>
                <div id="adMap" class="w-full h-[400px] rounded-lg shadow"></div>
            </div>

            {{-- Leaflet CSS/JS --}}
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const map = L.map('adMap').setView([{{ $ad->lat }}, {{ $ad->lng }}], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; Delni.co'
                    }).addTo(map);
                    const marker = L.marker([{{ $ad->lat }}, {{ $ad->lng }}]).addTo(map);
                    marker.bindPopup(`
                        <strong>{{ $ad->title }}</strong><br>
                        📍 {{ $ad->city }}<br>
                        💰 {{ number_format($ad->price) }} {{ __('messages.currency') }}
                    `);
                });
            </script>
        @endif

        {{-- 🧭 إعلانات مشابهة --}}
        @if($relatedAds->count())
            <div class="mt-20">
                <h2 class="text-2xl font-bold text-yellow-600 mb-6 text-center">🧭 {{ __('messages.related_ads') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($relatedAds as $related)
                        @php
                            $images = is_array($related->images) ? $related->images : json_decode($related->images, true);
                        @endphp
                        <a href="{{ route('ads.show', $related->id) }}"
                           class="block bg-white rounded-xl shadow hover:shadow-xl overflow-hidden transition duration-300">
                            <img src="{{ asset('storage/' . ($images[0] ?? 'placeholder.png')) }}"
                                 alt="Ad Image" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-base truncate mb-1">{{ $related->title }}</h3>
                                <p class="text-gray-600 text-sm">📍 {{ $related->city }}</p>
                                <p class="text-yellow-600 font-bold text-sm mt-2">💰 {{ number_format($related->price) }} {{ __('messages.currency') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-main-layout>
