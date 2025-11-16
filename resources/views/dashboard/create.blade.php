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

{{-- 💰 السعر + اختيار العملة --}}
<div>
    <x-label for="price" :value="__('messages.price')" />
    <div class="flex gap-3 items-center">
        <x-input id="price" class="block mt-1 w-1/2" type="number" name="price" :value="old('price')" required />
        <select name="currency" class="block mt-1 w-1/2 border-gray-300 rounded-md focus:ring-yellow-500 focus:border-yellow-500">
            <option value="SYP" {{ old('currency') == 'SYP' ? 'selected' : '' }}>🇸🇾 ل.س (الليرة السورية)</option>
            <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>🇺🇸 $ (الدولار الأمريكي)</option>
        </select>
    </div>
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

{{-- 🏷️ نوع العرض --}}
<div>
    <x-label for="deal_type" :value="__('messages.deal_type')" />
    <select id="deal_type" name="deal_type" class="block mt-1 w-full border-gray-300 rounded">
        <option value="sale">{{ __('messages.sale') }}</option>
        <option value="rent">{{ __('messages.rent') }}</option>
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
<div x-show="category === 'سيارات'" class="space-y-3 mt-6 bg-white shadow-md rounded-2xl p-6">
    <h2 class="font-bold text-lg mb-4 flex items-center gap-2 text-gray-800">
        <i class="fas fa-car text-yellow-500"></i> تفاصيل السيارة
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        {{-- 🏷️ الشركة المصنعة --}}
        <div>
            <x-label for="car_brand" value="الشركة المصنعة" />
            <select name="car_brand" id="car_brand" class="input w-full">
                <option value="">اختر الشركة</option>
                @foreach([
                    'Abarth','Acura','Alfa Romeo','Aston Martin','Audi','Bentley','BMW','Bugatti','BYD',
                    'Cadillac','Changan','Chery','Chevrolet','Chrysler','Citroen','Cupra','Dacia','Daewoo',
                    'Daihatsu','Dodge','Ferrari','Fiat','Ford','Genesis','Geely','GMC','Great Wall','Haval',
                    'Honda','Hummer','Hyundai','Infiniti','Isuzu','Jaguar','Jeep','Kia','Koenigsegg','Lada',
                    'Lamborghini','Lancia','Land Rover','Lexus','Lincoln','Lotus','Maserati','Maybach','Mazda',
                    'McLaren','Mercedes-Benz','Mini','Mitsubishi','Nissan','Opel','Pagani','Peugeot','Polestar',
                    'Porsche','Proton','Renault','Rolls-Royce','Saab','Seat','Skoda','Smart','SsangYong','Subaru',
                    'Suzuki','Tata','Tesla','Toyota','Volkswagen','Volvo','Wuling','Zotye'
                ] as $brand)
                    <option value="{{ $brand }}" {{ old('car_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                @endforeach
            </select>
        </div>

        {{-- 📦 الموديل --}}
        <div>
            <x-label for="car_model" value="الموديل" />
            <x-input type="text" id="car_model" name="car_model" placeholder="مثال: Corolla أو E200" class="w-full" />
        </div>

        {{-- 📅 سنة الصنع --}}
        <div>
            <x-label for="car_year" value="سنة الصنع" />
            <select name="car_year" id="car_year" class="input w-full">
                <option value="">اختر السنة</option>
                @for ($y = date('Y'); $y >= 1980; $y--)
                    <option value="{{ $y }}" {{ old('car_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>

        {{-- ⛽ نوع الوقود --}}
        <div>
            <x-label for="fuel" value="نوع الوقود" />
            <select name="fuel" id="fuel" class="input w-full">
                <option value="">اختر نوع الوقود</option>
                <option value="بنزين" {{ old('fuel')=='بنزين'?'selected':'' }}>بنزين</option>
                <option value="ديزل" {{ old('fuel')=='ديزل'?'selected':'' }}>ديزل</option>
                <option value="كهرباء" {{ old('fuel')=='كهرباء'?'selected':'' }}>كهرباء</option>
                <option value="هجين" {{ old('fuel')=='هجين'?'selected':'' }}>هجين</option>
            </select>
        </div>

        {{-- ⚙️ نوع الجير --}}
        <div>
            <x-label for="gearbox" value="ناقل الحركة" />
            <select name="gearbox" id="gearbox" class="input w-full">
                <option value="">اختر ناقل الحركة</option>
                <option value="أوتوماتيك" {{ old('gearbox')=='أوتوماتيك'?'selected':'' }}>أوتوماتيك</option>
                <option value="عادي" {{ old('gearbox')=='عادي'?'selected':'' }}>عادي</option>
            </select>
        </div>

        {{-- 🎨 اللون --}}
        <div>
            <x-label for="car_color" value="اللون" />
            <select name="car_color" id="car_color" class="input w-full">
                <option value="">اختر اللون</option>
                @foreach(['أبيض','أسود','رمادي','فضي','أزرق','أحمر','ذهبي','زيتي','بني','أخضر','برتقالي','بيج'] as $color)
                    <option value="{{ $color }}" {{ old('car_color') == $color ? 'selected' : '' }}>{{ $color }}</option>
                @endforeach
            </select>
        </div>

        {{-- 📏 عدد الكيلومترات --}}
        <div>
            <x-label for="car_km" value="عدد الكيلومترات (كم)" />
            <x-input type="number" id="car_km" name="car_km" placeholder="مثال: 85000" class="w-full" />
        </div>

        {{-- 🚘 حالة السيارة --}}
        <div class="flex items-center mt-6">
            <input id="is_new" name="is_new" type="checkbox" value="1" class="rounded border-gray-300">
            <label for="is_new" class="ml-2 text-gray-700">🚘 جديدة</label>
        </div>
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
