{{-- resources/views/dashboard/create.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">{{ __('messages.add_ad') }}</h1>

        {{-- ✅ عرض الأخطاء --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ نموذج إضافة إعلان --}}
        <form method="POST" action="{{ route('dashboard.ads.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- 📝 العنوان --}}
            <div>
                <x-label for="title" :value="__('messages.title')" />
                <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
            </div>

            {{-- 📄 الوصف --}}
            <div>
                <x-label for="description" :value="__('messages.description')" />
                <textarea id="description" name="description" rows="4" class="w-full rounded border-gray-300">{{ old('description') }}</textarea>
            </div>

            {{-- 💰 السعر --}}
            <div>
                <x-label for="price" :value="__('messages.price')" />
                <x-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" required />
            </div>

            {{-- 🏙️ المدينة --}}
            <div>
                <x-label for="city" :value="__('messages.city')" />
                <select id="city" name="city" class="block mt-1 w-full border-gray-300 rounded" required>
                    <option value="">{{ __('messages.choose_city') }}</option>
                    @foreach(['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','السويداء','درعا','القنيطرة','إدلب','الرقة','دير الزور','الحسكة'] as $city)
                        <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 📂 التصنيف --}}
            <div>
                <x-label for="category" :value="__('messages.category')" />
                <select id="category" name="category" class="block mt-1 w-full border-gray-300 rounded" required>
                    <option value="">{{ __('messages.choose_category') }}</option>
                    <option value="عقارات" {{ old('category') == 'عقارات' ? 'selected' : '' }}>عقارات</option>
                    <option value="سيارات" {{ old('category') == 'سيارات' ? 'selected' : '' }}>سيارات</option>
                </select>
            </div>

            {{-- 🖼️ رفع الصور --}}
            <div>
                <x-label for="images" :value="__('messages.images')" />
                <input type="file" name="images[]" id="images" multiple class="w-full border-gray-300 rounded" />
            </div>

            {{-- 🗺️ خريطة تحديد الموقع --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1 text-gray-700">📍 {{ __('messages.select_location_on_map') }}</label>
                <div id="map" class="w-full h-64 rounded-lg shadow"></div>
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lng" id="lng">
            </div>

            {{-- 🌐 مكتبة الخرائط --}}
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const defaultLat = 33.5138;
                    const defaultLng = 36.2765;

                    const map = L.map('map').setView([defaultLat, defaultLng], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors',
                    }).addTo(map);

                    let marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

                    marker.on('dragend', function (e) {
                        const position = marker.getLatLng();
                        document.getElementById('lat').value = position.lat;
                        document.getElementById('lng').value = position.lng;
                    });

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function (position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            map.setView([lat, lng], 15);
                            marker.setLatLng([lat, lng]);
                            document.getElementById('lat').value = lat;
                            document.getElementById('lng').value = lng;
                        });
                    }
                });
            </script>

            {{-- ✅ زر نشر الإعلان --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded text-lg font-semibold">
                    {{ __('messages.submit') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
