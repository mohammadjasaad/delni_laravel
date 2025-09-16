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
        <form method="POST" action="{{ route('dashboard.ads.store') }}" enctype="multipart/form-data" class="space-y-6" 
              x-data="{ category: '{{ old('category') }}' }">
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
                    @foreach(['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','السويداء','درعا','القنيطرة','إدلب','الرقة','دير الزور','الحسكة','تركيا'] as $city)
                        <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 📂 التصنيف --}}
            <div>
                <x-label for="category" :value="__('messages.category')" />
                <select id="category" name="category" 
                        x-model="category"
                        class="block mt-1 w-full border-gray-300 rounded" required>
                    <option value="">{{ __('messages.choose_category') }}</option>
                    <option value="عقارات">🏠 عقارات</option>
                    <option value="سيارات">🚗 سيارات</option>
                    <option value="خدمات">🛠️ خدمات</option>
                </select>
            </div>

            {{-- 🖼️ رفع الصور --}}
            <div>
                <x-label for="images" :value="__('messages.images')" />
                <input type="file" name="images[]" id="images" multiple class="w-full border-gray-300 rounded" />
                <p class="text-sm text-gray-500 mt-1">
                    {{ __('messages.upload_multiple_images') ?? 'يمكنك رفع عدة صور (JPG, PNG, WEBP) بحد أقصى 10MB لكل صورة' }}
                </p>
            </div>

{{-- 🏠 خصائص العقارات --}}
<div x-show="category === 'عقارات'" class="space-y-3">
    <h2 class="font-bold text-lg">🏠 تفاصيل العقار</h2>
    <div class="grid grid-cols-2 gap-4">
        <x-input type="number" name="rooms" placeholder="عدد الغرف" />
        <x-input type="number" name="bathrooms" placeholder="عدد الحمامات" />
        <x-input type="number" name="area_total" placeholder="المساحة الإجمالية م²" />
        <x-input type="number" name="area_net" placeholder="المساحة الصافية م²" />
        <x-input type="number" name="floor" placeholder="الطابق" />
        <x-input type="number" name="building_age" placeholder="عمر البناء" />
        <label class="flex items-center"><input type="checkbox" name="has_elevator" class="mr-2"> مصعد</label>
        <label class="flex items-center"><input type="checkbox" name="has_parking" class="mr-2"> موقف سيارات</label>
        <x-input type="text" name="heating_type" placeholder="نوع التدفئة" />
    </div>
</div>

{{-- 🚗 خصائص السيارات --}}
<div x-show="category === 'سيارات'" class="space-y-3">
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
                <option value="{{ $brand }}" {{ old('car_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
            @endforeach
        </select>

        {{-- 📅 سنة الصنع --}}
        <select name="car_year" class="w-full p-3 border rounded-xl text-sm">
            <option value="">اختر سنة الصنع</option>
            @for ($y = date('Y'); $y >= 1980; $y--)
                <option value="{{ $y }}" {{ old('car_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>

        {{-- 📏 المسافة المقطوعة --}}
        <x-input type="number" name="car_km" placeholder="المسافة (كم)" value="{{ old('car_km') }}" />

        {{-- ⛽ نوع الوقود --}}
        <select name="fuel" class="w-full p-3 border rounded-xl text-sm">
            <option value="">نوع الوقود</option>
            <option value="بنزين" {{ old('fuel')=='بنزين'?'selected':'' }}>بنزين</option>
            <option value="ديزل" {{ old('fuel')=='ديزل'?'selected':'' }}>ديزل</option>
            <option value="كهرباء" {{ old('fuel')=='كهرباء'?'selected':'' }}>كهرباء</option>
            <option value="هجين" {{ old('fuel')=='هجين'?'selected':'' }}>هجين</option>
        </select>

        {{-- ⚙️ ناقل الحركة --}}
        <select name="gearbox" class="w-full p-3 border rounded-xl text-sm">
            <option value="">ناقل الحركة</option>
            <option value="أوتوماتيك" {{ old('gearbox')=='أوتوماتيك'?'selected':'' }}>أوتوماتيك</option>
            <option value="عادي" {{ old('gearbox')=='عادي'?'selected':'' }}>عادي</option>
        </select>

        {{-- 🎨 اللون --}}
        <x-input type="text" name="car_color" placeholder="اللون" value="{{ old('car_color') }}" />

        {{-- ✅ حالة السيارة --}}
        <label class="flex items-center">
            <input type="checkbox" name="is_new" {{ old('is_new') ? 'checked' : '' }} class="mr-2">
            🚘 جديد
        </label>
    </div>
</div>

            {{-- 🛠️ خصائص الخدمات --}}
            <div x-show="category === 'خدمات'" class="space-y-3">
                <h2 class="font-bold text-lg">🛠️ تفاصيل الخدمة</h2>
                <div class="grid grid-cols-2 gap-4">
                    <x-input type="text" name="service_type" placeholder="نوع الخدمة" />
                    <x-input type="text" name="provider_name" placeholder="اسم المزود" />
                </div>
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

                    marker.on('dragend', function () {
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
                    {{ __('messages.submit_ad') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
