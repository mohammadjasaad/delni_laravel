{{-- resources/views/ads/create.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- 🧭 العنوان --}}
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">
            ➕ {{ __('messages.add_ad') }}
        </h1>

        {{-- ❌ عرض الأخطاء --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-800 p-4 rounded">
                <ul class="list-disc pl-6 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ النموذج --}}
        <form action="{{ route('dashboard.ads.store') }}" method="POST" enctype="multipart/form-data" 
              class="space-y-6" x-data="{ category: '{{ old('category') }}' }">
            @csrf

            {{-- 📂 التصنيف --}}
            <div>
                <x-label for="category" :value="__('messages.category')" />
                <select id="category" name="category" x-model="category" required
                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="">{{ __('messages.select_category') }}</option>
                    <option value="realestate" {{ old('category') == 'realestate' ? 'selected' : '' }}>
                        🏠 {{ __('messages.real_estate') }}
                    </option>
                    <option value="cars" {{ old('category') == 'cars' ? 'selected' : '' }}>
                        🚗 {{ __('messages.cars') }}
                    </option>
                    <option value="services" {{ old('category') == 'services' ? 'selected' : '' }}>
                        🛠️ {{ __('messages.services') }}
                    </option>
                </select>
            </div>

            {{-- 🏙️ المدينة --}}
            <div>
                <x-label for="city" :value="__('messages.city')" />
                <select id="city" name="city" required
                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="">{{ __('messages.select_city') }}</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>
                            {{ $city }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 📝 العنوان --}}
            <div>
                <x-label for="title" :value="__('messages.title')" />
                <x-input id="title" type="text" name="title" class="w-full mt-1" 
                         value="{{ old('title') }}" required />
            </div>

            {{-- 🧾 الوصف --}}
            <div>
                <x-label for="description" :value="__('messages.description')" />
                <textarea id="description" name="description" rows="4"
                          class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
                          required>{{ old('description') }}</textarea>
            </div>

            {{-- 💰 السعر --}}
            <div>
                <x-label for="price" :value="__('messages.price')" />
                <x-input id="price" type="number" name="price" class="w-full mt-1" 
                         value="{{ old('price') }}" required />
            </div>


            {{-- 🖼️ الصور --}}
            <div>
                <x-label for="images" :value="__('messages.images')" />
                <input type="file" name="images[]" id="images" multiple
                       class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required />
                <p class="text-xs text-gray-500 mt-1">{{ __('messages.upload_multiple_images') }}</p>

                {{-- 📸 معاينة الصور --}}
                <div id="preview" class="flex flex-wrap gap-2 mt-2"></div>
            </div>

            {{-- 🏠 خصائص العقارات --}}
            <div x-show="category === 'realestate'" class="space-y-3">
                <h2 class="font-bold text-lg">🏠 {{ __('messages.real_estate_details') }}</h2>
                <div class="grid grid-cols-2 gap-4">
<x-input type="text" name="subcategory" placeholder="{{ __('messages.subcategory') }}" />
                    <x-input type="number" name="rooms" placeholder="{{ __('messages.rooms') }}" />
                    <x-input type="number" name="bathrooms" placeholder="{{ __('messages.bathrooms') }}" />
<x-input type="number" name="area_total" placeholder="المساحة الإجمالية م²" />
<x-input type="number" name="area_net" placeholder="المساحة الصافية م²" />
                    <x-input type="number" name="floor" placeholder="{{ __('messages.floor') }}" />
                    <x-input type="number" name="building_age" placeholder="{{ __('messages.building_age') }}" />
                    <label class="flex items-center"><input type="checkbox" name="has_elevator" class="mr-2"> {{ __('messages.elevator') }}</label>
                    <label class="flex items-center"><input type="checkbox" name="has_parking" class="mr-2"> {{ __('messages.parking') }}</label>
                    <x-input type="text" name="heating_type" placeholder="{{ __('messages.heating') }}" />
                </div>
            </div>

            {{-- 🚗 خصائص السيارات --}}
            <div x-show="category === 'cars'" class="space-y-3">
                <h2 class="font-bold text-lg">🚗 {{ __('messages.car_details') }}</h2>
                <div class="grid grid-cols-2 gap-4">
                    <x-input type="text" name="car_model" placeholder="{{ __('messages.car_model') }}" />
                    <x-input type="number" name="car_year" placeholder="{{ __('messages.car_year') }}" />
                    <x-input type="number" name="car_km" placeholder="{{ __('messages.car_km') }}" />
                    <x-input type="text" name="fuel" placeholder="{{ __('messages.fuel') }}" />
                    <x-input type="text" name="gearbox" placeholder="{{ __('messages.gearbox') }}" />
                    <x-input type="text" name="car_color" placeholder="{{ __('messages.color') }}" />
                    <label class="flex items-center"><input type="checkbox" name="is_new" class="mr-2"> {{ __('messages.new') }}</label>
                </div>
            </div>

            {{-- 🛠️ خصائص الخدمات --}}
            <div x-show="category === 'services'" class="space-y-3">
                <h2 class="font-bold text-lg">🛠️ {{ __('messages.service_details') }}</h2>
                <div class="grid grid-cols-2 gap-4">
                    <x-input type="text" name="service_type" placeholder="{{ __('messages.service_type') }}" />
                    <x-input type="text" name="provider_name" placeholder="{{ __('messages.provider_name') }}" />
                </div>
            </div>

            {{-- 🗺️ خريطة تحديد الموقع --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1 text-gray-700">📍 {{ __('messages.select_location_on_map') }}</label>
                <div id="map" class="w-full h-64 rounded-lg shadow"></div>
                <input type="hidden" name="lat" id="lat" value="{{ old('lat') }}">
                <input type="hidden" name="lng" id="lng" value="{{ old('lng') }}">
            </div>

            {{-- ✅ زر الإرسال --}}
            <div>
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-3 rounded-xl w-full transition">
                    📢 {{ __('messages.submit') }}
                </button>
            </div>
        </form>
    </div>

    {{-- 📸 Script معاينة الصور --}}
    <script>
        document.getElementById('images').addEventListener('change', function(e) {
            let preview = document.getElementById('preview');
            preview.innerHTML = "";
            Array.from(e.target.files).forEach(file => {
                let reader = new FileReader();
                reader.onload = e => {
                    let img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList = "h-24 w-32 object-cover rounded-lg shadow";
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>

    {{-- 🌐 خريطة Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('map').setView([33.5138, 36.2765], 10); // دمشق افتراضيًا
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
            }).addTo(map);

            let marker;
            map.on('click', function(e) {
                if (marker) marker.remove();
                marker = L.marker(e.latlng).addTo(map);
                document.getElementById('lat').value = e.latlng.lat;
                document.getElementById('lng').value = e.latlng.lng;
            });
        });
    </script>
</x-app-layout>
