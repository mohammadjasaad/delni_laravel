{{-- resources/views/emergency-services/index.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- 🟡 العنوان --}}
        <h1 class="text-3xl font-bold text-center text-yellow-600 mb-6">
            🆘 {{ __('messages.delni_emergency') }}
        </h1>

        {{-- 🗺️ الخريطة --}}
        <div id="emergencyMap" class="w-full h-[400px] md:h-[500px] rounded-lg shadow mb-10"></div>

        {{-- ✅ تبويبات مثل الرئيسية --}}
        <div class="flex flex-wrap gap-3 justify-center mb-8">
            <a href="{{ route('home') }}" class="sub-tab">🏠 {{ __('messages.real_estate') }}</a>
            <a href="{{ route('home') }}?category=cars" class="sub-tab">🚗 {{ __('messages.cars') }}</a>
            <a href="{{ route('home') }}?category=services" class="sub-tab">🛠️ {{ __('messages.services') }}</a>
            <a href="{{ route('emergency.index') }}" class="sub-tab active">🚨 {{ __('messages.delni_emergency') }}</a>
        </div>

        {{-- 🔍 نموذج الفلترة --}}
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" action="{{ route('emergency.index') }}" class="flex flex-wrap gap-4 justify-center items-end">
                {{-- 🏙️ المدينة --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.city') }}</label>
                    <input type="text" name="city" value="{{ request('city') }}"
                           class="border border-gray-300 rounded px-3 py-2 w-48"
                           placeholder="دمشق، حلب...">
                </div>

                {{-- 🛠️ النوع --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.category') }}</label>
                    <select name="type" class="border border-gray-300 rounded px-3 py-2 w-48">
                        <option value="">{{ __('messages.all_ads') }}</option>
                        <option value="رافعة" {{ request('type') == 'رافعة' ? 'selected' : '' }}>رافعة</option>
                        <option value="مركز صيانة" {{ request('type') == 'مركز صيانة' ? 'selected' : '' }}>مركز صيانة</option>
                    </select>
                </div>

                {{-- 🔘 زر بحث --}}
                <div>
                    <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-5 py-2 rounded shadow">
                        🔍 {{ __('messages.filter') }}
                    </button>
                </div>

                {{-- ↩️ إعادة تعيين --}}
                <div>
                    <a href="{{ route('emergency.index') }}"
                       class="text-gray-600 hover:text-black underline text-sm">{{ __('messages.reset') }}</a>
                </div>
            </form>
        </div>

        {{-- 🛠️ شبكة مراكز الطوارئ --}}
        @if($services->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($services as $service)
                    <div class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden border border-gray-200 transition">
                        <div class="p-5">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">🔧 {{ $service->name }}</h2>
                            <p class="text-sm text-gray-500"><i class="fas fa-map-marker-alt text-red-500"></i> {{ $service->city }}</p>
                            <p class="text-sm text-gray-500">🛠️ النوع: {{ $service->type }}</p>
                            <p class="text-xs text-gray-400">📌 {{ $service->lat }}, {{ $service->lng }}</p>

                            <div class="flex gap-3 mt-4">
                                <a href="{{ route('emergency_services.show', $service->id) }}"
                                   class="text-sm bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                    👁️ عرض
                                </a>
                                <button onclick="openReportModal({{ $service->id }})"
                                        class="text-sm bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                    🚫 إبلاغ
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500">{{ __('messages.no_data') }}</p>
        @endif

    </div>

    {{-- ✅ مكتبة Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- ✅ سكربت الخريطة --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('emergencyMap').setView([34.8021, 38.9968], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni.co'
            }).addTo(map);

            @foreach($services as $service)
                @if($service->lat && $service->lng)
                    L.marker([{{ $service->lat }}, {{ $service->lng }}])
                        .addTo(map)
                        .bindPopup("🔧 {{ $service->name }} <br> 🏙️ {{ $service->city }} <br> 🛠️ {{ $service->type }}");
                @endif
            @endforeach
        });
    </script>
</x-app-layout>
