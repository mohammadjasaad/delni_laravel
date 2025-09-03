{{-- resources/views/dashboard/edit.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">{{ __('messages.edit_ad') }}</h1>

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

        {{-- ✅ نموذج تعديل إعلان --}}
        <form method="POST" action="{{ route('dashboard.ads.update', $ad->id) }}" enctype="multipart/form-data" 
              class="space-y-6" x-data="{ category: '{{ old('category', $ad->category) }}' }">
            @csrf
            @method('PUT')

            {{-- 📝 العنوان --}}
            <div>
                <x-label for="title" :value="__('messages.title')" />
                <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title', $ad->title) }}" required />
            </div>

            {{-- 📄 الوصف --}}
            <div>
                <x-label for="description" :value="__('messages.description')" />
                <textarea id="description" name="description" rows="4" class="w-full rounded border-gray-300">{{ old('description', $ad->description) }}</textarea>
            </div>

            {{-- 💰 السعر --}}
            <div>
                <x-label for="price" :value="__('messages.price')" />
                <x-input id="price" class="block mt-1 w-full" type="number" name="price" value="{{ old('price', $ad->price) }}" required />
            </div>

            {{-- 🏙️ المدينة --}}
            <div>
                <x-label for="city" :value="__('messages.city')" />
                <select id="city" name="city" class="block mt-1 w-full border-gray-300 rounded" required>
                    <option value="">{{ __('messages.choose_city') }}</option>
                    @foreach(['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','السويداء','درعا','القنيطرة','إدلب','الرقة','دير الزور','الحسكة','تركيا'] as $city)
                        <option value="{{ $city }}" {{ old('city', $ad->city) == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 📂 التصنيف --}}
            <div>
                <x-label for="category" :value="__('messages.category')" />
                <select id="category" name="category" x-model="category" class="block mt-1 w-full border-gray-300 rounded" required>
                    <option value="">{{ __('messages.choose_category') }}</option>
                    <option value="realestate" {{ old('category', $ad->category) == 'realestate' ? 'selected' : '' }}>🏠 {{ __('messages.real_estate') }}</option>
                    <option value="cars" {{ old('category', $ad->category) == 'cars' ? 'selected' : '' }}>🚗 {{ __('messages.cars') }}</option>
                    <option value="services" {{ old('category', $ad->category) == 'services' ? 'selected' : '' }}>🛠️ {{ __('messages.services') }}</option>
                </select>
            </div>

            {{-- 🖼️ الصور الحالية + رفع صور جديدة --}}
            <div>
                <x-label for="images" :value="__('messages.images')" />
                <div class="flex flex-wrap gap-3 mb-3">
                    @foreach((is_array($ad->images) ? $ad->images : json_decode($ad->images, true)) ?? [] as $img)
                        <img src="{{ asset('storage/'.$img) }}" class="w-24 h-24 object-cover rounded border" />
                    @endforeach
                </div>
                <input type="file" name="images[]" id="images" multiple class="w-full border-gray-300 rounded" />
            </div>

            {{-- 🏠 خصائص العقارات --}}
            <div x-show="category === 'realestate'" class="space-y-3">
                <h2 class="font-bold text-lg">🏠 تفاصيل العقار</h2>
                <div class="grid grid-cols-2 gap-4">
                    <x-input type="number" name="rooms" placeholder="عدد الغرف" value="{{ old('rooms', $ad->rooms) }}" />
                    <x-input type="number" name="bathrooms" placeholder="عدد الحمامات" value="{{ old('bathrooms', $ad->bathrooms) }}" />
                    <x-input type="number" name="area" placeholder="المساحة م²" value="{{ old('area', $ad->area) }}" />
                    <x-input type="number" name="floor" placeholder="الطابق" value="{{ old('floor', $ad->floor) }}" />
                    <x-input type="number" name="building_age" placeholder="عمر البناء" value="{{ old('building_age', $ad->building_age) }}" />
                    <label class="flex items-center"><input type="checkbox" name="has_elevator" {{ $ad->has_elevator ? 'checked' : '' }} class="mr-2"> مصعد</label>
                    <label class="flex items-center"><input type="checkbox" name="has_parking" {{ $ad->has_parking ? 'checked' : '' }} class="mr-2"> موقف سيارات</label>
                    <x-input type="text" name="heating_type" placeholder="نوع التدفئة" value="{{ old('heating_type', $ad->heating_type) }}" />
                </div>
            </div>

            {{-- 🚗 خصائص السيارات --}}
            <div x-show="category === 'cars'" class="space-y-3">
                <h2 class="font-bold text-lg">🚗 تفاصيل السيارة</h2>
                <div class="grid grid-cols-2 gap-4">

                    {{-- 🏷️ الشركة المصنعة --}}
                    <select name="car_brand" class="w-full p-3 border rounded-xl text-sm">
                        <option value="">اختر الشركة المصنعة</option>
                        @foreach([
                            'Abarth','Alfa Romeo','Aston Martin','Audi','Bentley','BMW','BYD','Cadillac','Chery','Chevrolet',
                            'Chrysler','Citroen','Cupra','Dacia','Daewoo','Daihatsu','Dodge','Ferrari','Fiat','Ford',
                            'Geely','Honda','Hyundai','Infiniti','Jaguar','Jeep','Kia','Lada','Lamborghini','Land Rover',
                            'Lexus','Lincoln','Maserati','Mazda','McLaren','Mercedes-Benz','Mini','Mitsubishi','Nissan',
                            'Opel','Peugeot','Porsche','Renault','Rolls-Royce','Saab','Seat','Skoda','Smart','Subaru',
                            'Suzuki','Tesla','Toyota','Volkswagen','Volvo'
                        ] as $brand)
                            <option value="{{ $brand }}" 
                                    {{ old('car_brand', $ad->car_brand) == $brand ? 'selected' : '' }}>
                                    {{ $brand }}
                            </option>
                        @endforeach
                    </select>

                    {{-- 📅 سنة الصنع --}}
                    <select name="car_year" class="w-full p-3 border rounded-xl text-sm">
                        <option value="">اختر سنة الصنع</option>
                        @for ($y = date('Y'); $y >= 1980; $y--)
                            <option value="{{ $y }}" 
                                    {{ old('car_year', $ad->car_year) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                            </option>
                        @endfor
                    </select>

                    {{-- 📏 المسافة المقطوعة --}}
                    <x-input type="number" name="car_km" placeholder="المسافة (كم)" 
                             value="{{ old('car_km', $ad->car_km) }}" />

                    {{-- ⛽ نوع الوقود --}}
                    <select name="fuel" class="w-full p-3 border rounded-xl text-sm">
                        <option value="">نوع الوقود</option>
                        <option value="بنزين" {{ old('fuel', $ad->fuel) == 'بنزين' ? 'selected' : '' }}>بنزين</option>
                        <option value="ديزل" {{ old('fuel', $ad->fuel) == 'ديزل' ? 'selected' : '' }}>ديزل</option>
                        <option value="كهرباء" {{ old('fuel', $ad->fuel) == 'كهرباء' ? 'selected' : '' }}>كهرباء</option>
                        <option value="هجين" {{ old('fuel', $ad->fuel) == 'هجين' ? 'selected' : '' }}>هجين</option>
                    </select>

                    {{-- ⚙️ ناقل الحركة --}}
                    <select name="gearbox" class="w-full p-3 border rounded-xl text-sm">
                        <option value="">ناقل الحركة</option>
                        <option value="أوتوماتيك" {{ old('gearbox', $ad->gearbox) == 'أوتوماتيك' ? 'selected' : '' }}>أوتوماتيك</option>
                        <option value="عادي" {{ old('gearbox', $ad->gearbox) == 'عادي' ? 'selected' : '' }}>عادي</option>
                    </select>

                    {{-- 🎨 اللون --}}
                    <x-input type="text" name="car_color" placeholder="اللون" 
                             value="{{ old('car_color', $ad->car_color) }}" />

                    {{-- ✅ حالة السيارة --}}
                    <label class="flex items-center">
                        <input type="checkbox" name="is_new" 
                               {{ old('is_new', $ad->is_new) ? 'checked' : '' }} class="mr-2">
                        🚘 جديد
                    </label>
                </div>
            </div>

            {{-- 🛠️ خصائص الخدمات --}}
            <div x-show="category === 'services'" class="space-y-3">
                <h2 class="font-bold text-lg">🛠️ تفاصيل الخدمة</h2>
                <div class="grid grid-cols-2 gap-4">
                    <x-input type="text" name="service_type" placeholder="نوع الخدمة" value="{{ old('service_type', $ad->service_type) }}" />
                    <x-input type="text" name="provider_name" placeholder="اسم المزود" value="{{ old('provider_name', $ad->provider_name) }}" />
                </div>
            </div>

            {{-- 🗺️ خريطة تحديد الموقع --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1 text-gray-700">📍 {{ __('messages.select_location_on_map') }}</label>
                <div id="map" class="w-full h-64 rounded-lg shadow"></div>
                <input type="hidden" name="lat" id="lat" value="{{ old('lat', $ad->lat) }}">
                <input type="hidden" name="lng" id="lng" value="{{ old('lng', $ad->lng) }}">
            </div>

            {{-- 🌐 مكتبة الخرائط --}}
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const defaultLat = {{ old('lat', $ad->lat ?? 33.5138) }};
                    const defaultLng = {{ old('lng', $ad->lng ?? 36.2765) }};

                    const map = L.map('map').setView([defaultLat, defaultLng], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors',
                    }).addTo(map);

                    let marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

                    marker.on('dragend', function () {
                        const position = marker.getLatLng();
                        document.getElementById('lat').value = position.lat;
                        document.getElementById('lng').value = position.lng;
                    });
                });
            </script>

            {{-- ✅ زر تعديل الإعلان --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded text-lg font-semibold">
                    {{ __('messages.update_ad') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
