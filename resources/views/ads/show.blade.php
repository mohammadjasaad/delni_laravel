
<x-main-layout>
    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- 🔙 رجوع --}}
        <div class="mb-4">
            <a href="{{ route('ads.index') }}" class="text-yellow-600 hover:underline text-sm">← {{ __('messages.back_to_ads') }}</a>
        </div>

        {{-- 🏷️ العنوان --}}
        <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-2">{{ $ad->title }}</h1>

        {{-- ⭐ إعلان مميز --}}
        @if($ad->is_featured)
            <div class="text-center mb-4">
                <span class="inline-block bg-yellow-500 text-white font-bold px-4 py-2 rounded-full shadow">⭐ {{ __('messages.featured_ad') }}</span>
            </div>
        @endif

        {{-- 🖼️ صورة رئيسية --}}
        @php $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true); @endphp
        @if($images && count($images) > 0)
            <div class="relative mb-6">
                <img src="{{ \Illuminate\Support\Str::startsWith($images[0], 'http') ? $images[0] : asset($images[0]) }}"
                     class="w-full h-72 sm:h-[400px] object-cover rounded-xl shadow" alt="Main Image">
            </div>
        @endif

        {{-- 🔁 التبويبات --}}
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex justify-center gap-8 text-sm sm:text-base font-semibold text-gray-500">
                <button onclick="showTab('details')" class="tab-btn border-b-2 px-3 py-2 text-gray-700 border-yellow-500">📋 {{ __('messages.details') }}</button>
                <button onclick="showTab('description')" class="tab-btn border-b-2 px-3 py-2 hover:text-yellow-600">📝 {{ __('messages.description') }}</button>
                <button onclick="showTab('map')" class="tab-btn border-b-2 px-3 py-2 hover:text-yellow-600">📍 {{ __('messages.ad_location') }}</button>
            </nav>
        </div>

        {{-- ✅ التفاصيل --}}
        <div id="details" class="tab-content">
            <div class="bg-white rounded-xl shadow-md p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700 text-sm sm:text-base">
                <p><strong>{{ __('messages.price') }}:</strong> 💰 {{ number_format($ad->price) }} {{ __('messages.currency') }}</p>
                <p><strong>{{ __('messages.city') }}:</strong> 📍 {{ $ad->city }}</p>
                <p><strong>{{ __('messages.category') }}:</strong> 🗂️ {{ $ad->category }}</p>
                <p><strong>{{ __('messages.created_at') }}:</strong> ⏰ {{ $ad->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        {{-- 📝 وصف --}}
        <div id="description" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-md p-6 text-gray-700 leading-relaxed text-sm sm:text-base whitespace-pre-line">
                {{ $ad->description }}
            </div>
        </div>

        {{-- 🗺️ الخريطة --}}
        <div id="map" class="tab-content hidden">
            @if ($ad->lat && $ad->lng)
                <div id="adMap" class="w-full h-[400px] rounded-xl shadow mt-2"></div>
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const map = L.map('adMap').setView({{ $ad->lat }}, {{ $ad->lng }}], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; Delni.co'
                        }).addTo(map);
                        L.marker({{ $ad->lat }}, {{ $ad->lng }}]).addTo(map)
                            .bindPopup(`<strong>{{ $ad->title }}</strong><br>📍 {{ $ad->city }}<br>💰 {{ number_format($ad->price) }} {{ __('messages.currency') }}`);
                    });
                </script>
            @endif
        </div>

        {{-- 📞 التواصل --}}
        @if($ad->phone)
            <div class="mt-10 flex flex-wrap gap-4 justify-center">
                <a href="tel:{{ preg_replace('/[^0-9]/', '', $ad->phone) }}"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full shadow text-sm">
                    📞 {{ __('messages.direct_call') }}
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ad->phone) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full shadow text-sm">
                    🟢 {{ __('messages.whatsapp') }}
                </a>
            </div>
        @endif

        {{-- ❤️ مفضلة --}}
        @auth
            <form method="POST" action="{{ route('favorites.store', $ad->id) }}" class="text-center mt-6">
                @csrf
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-8 rounded-full shadow text-sm">
                    ❤️ {{ __('messages.add_to_favorite') }}
                </button>
            </form>
        @endauth

        {{-- 🔗 مشاركة --}}
        <div class="mt-8 text-center flex flex-wrap justify-center gap-4">
            <button onclick="copyToClipboard('{{ route('ads.show', $ad->id) }}')"
                    class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-2 rounded-full shadow text-sm">
                📋 {{ __('messages.copy_link') }}
            </button>
            <a href="https://wa.me/?text={{ urlencode('👋 مرحبًا، شاهد هذا الإعلان: ' . $ad->title . ' - ' . route('ads.show', $ad->id)) }}"
               target="_blank"
               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-full shadow text-sm">
                📲 {{ __('messages.share_on_whatsapp') }}
            </a>
        </div>

        {{-- 🚨 بلاغ --}}
        <div class="bg-white rounded-xl shadow-md p-6 mt-10">
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

        {{-- 🧭 إعلانات مشابهة --}}
        @if($relatedAds->count())
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-yellow-600 mb-6 text-center">🧭 {{ __('messages.related_ads') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($relatedAds as $related)
                        @php
                            $images = is_array($related->images) ? $related->images : json_decode($related->images, true);
                            $relatedImage = $images && isset($images[0]) ? (\Illuminate\Support\Str::startsWith($images[0], 'http') ? $images[0] : asset($images[0])) : asset('placeholder.png');
                        @endphp
                        <a href="{{ route('ads.show', $related->id) }}"
                           class="block bg-white rounded-xl shadow hover:shadow-xl overflow-hidden transition duration-300">
                            <img src="{{ $relatedImage }}" alt="Ad Image" class="w-full h-48 object-cover">
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

    {{-- ✅ سكربت تبويبات ونسخ --}}
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => alert("✅ {{ __('messages.link_copied') }}"));
        }

        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById(tabId).classList.remove('hidden');
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('text-gray-700', 'border-yellow-500'));
            event.target.classList.add('text-gray-700', 'border-yellow-500');
        }
    </script>
</x-main-layout>
