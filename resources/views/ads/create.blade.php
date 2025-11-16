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

{{-- 💵 العملة --}}
<div>
    <x-label for="currency" value="العملة" />
    <select id="currency" name="currency"
            class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
        <option value="SYP" selected>الليرة السورية (SYP)</option>
        <option value="USD">الدولار الأمريكي (USD)</option>
    </select>
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
<div x-show="category === 'realestate'" class="space-y-6">
    <h2 class="font-bold text-lg border-b pb-2 text-gray-700">
        🏠 تفاصيل العقار
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- نوع العرض --}}
        <div>
            <x-label for="deal_type" value="نوع العرض" />
            <select id="deal_type" name="deal_type"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر نوع العرض</option>
                <option value="sale" {{ old('deal_type') == 'sale' ? 'selected' : '' }}>بيع 🏷️</option>
                <option value="rent" {{ old('deal_type') == 'rent' ? 'selected' : '' }}>إيجار 🏠</option>
            </select>
        </div>

        {{-- نوع العقار --}}
        <div>
            <x-label for="subcategory" value="نوع العقار" />
            <select id="subcategory" name="subcategory"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر نوع العقار</option>
                <option value="residential">سكني</option>
                <option value="commercial">تجاري</option>
                <option value="land">أرض</option>
                <option value="villa">فيلا</option>
                <option value="office">مكتب</option>
                <option value="building">بناء كامل</option>
            </select>
        </div>

        {{-- عدد الغرف --}}
        <div>
            <x-label for="rooms" value="عدد الغرف" />
            <select id="rooms" name="rooms"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر عدد الغرف</option>
                <option value="1+0">1+0</option>
                <option value="1+1">1+1</option>
                <option value="2+1">2+1</option>
                <option value="3+1">3+1</option>
                <option value="4+1">4+1</option>
                <option value="5+1">5+1</option>
                <option value="6+1">6+1</option>
            </select>
        </div>

        {{-- عدد الحمامات --}}
        <div>
            <x-label for="bathrooms" value="عدد الحمامات" />
            <select id="bathrooms" name="bathrooms"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر عدد الحمامات</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>

        {{-- المساحة الإجمالية --}}
        <div>
            <x-label for="area_total" value="المساحة الإجمالية م²" />
            <x-input id="area_total" name="area_total" type="number"
                     placeholder="مثال: 150" class="w-full mt-1" />
        </div>

        {{-- المساحة الصافية --}}
        <div>
            <x-label for="area_net" value="المساحة الصافية م²" />
            <x-input id="area_net" name="area_net" type="number"
                     placeholder="مثال: 120" class="w-full mt-1" />
        </div>

        {{-- الطابق --}}
        <div>
            <x-label for="floor" value="الطابق" />
            <select id="floor" name="floor"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر الطابق</option>
                <option value="ground">الأرضي</option>
                <option value="1">الأول</option>
                <option value="2">الثاني</option>
                <option value="3">الثالث</option>
                <option value="4">الرابع</option>
                <option value="5">الخامس</option>
                <option value="6+">أعلى من الخامس</option>
            </select>
        </div>

        {{-- عمر البناء --}}
        <div>
            <x-label for="building_age" value="عمر البناء" />
            <select id="building_age" name="building_age"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر عمر البناء</option>
                <option value="new">جديد</option>
                <option value="1-5">1 - 5 سنوات</option>
                <option value="6-10">6 - 10 سنوات</option>
                <option value="10+">أكثر من 10 سنوات</option>
            </select>
        </div>

        {{-- التدفئة --}}
        <div>
            <x-label for="heating_type" value="نوع التدفئة" />
            <select id="heating_type" name="heating_type"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر نوع التدفئة</option>
                <option value="مركزي">مركزي</option>
                <option value="غاز">غاز</option>
                <option value="كهرباء">كهرباء</option>
                <option value="مازوت">مازوت</option>
                <option value="بدون">بدون تدفئة</option>
            </select>
        </div>

        {{-- المصعد --}}
        <label class="flex items-center">
            <input type="checkbox" name="has_elevator" class="mr-2">
            {{ __('messages.elevator') }}
        </label>

        {{-- موقف سيارات --}}
        <label class="flex items-center">
            <input type="checkbox" name="has_parking" class="mr-2">
            {{ __('messages.parking') }}
        </label>
    </div>
</div>

{{-- 🚗 خصائص السيارات --}}
<div x-show="category === 'cars'" class="space-y-6 mt-6 bg-white shadow-md rounded-2xl p-6">
    <h2 class="font-bold text-lg mb-4 flex items-center gap-2 text-gray-800 border-b pb-2">
        <i class="fas fa-car text-yellow-500"></i> تفاصيل السيارة
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        {{-- 🏷️ الشركة المصنعة --}}
        <div>
            <x-label for="car_brand" value="الشركة المصنعة" />
            <select id="car_brand" name="car_brand"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر الشركة</option>
                @php
                    $brands = [
                        'Audi'=>'أودي','BMW'=>'بي إم دبليو','Mercedes-Benz'=>'مرسيدس','Toyota'=>'تويوتا','Hyundai'=>'هيونداي','Kia'=>'كيا',
                        'Renault'=>'رينو','Nissan'=>'نيسان','Volkswagen'=>'فولكس فاغن','Volvo'=>'فولفو','Chevrolet'=>'شيفروليه','Ford'=>'فورد',
                        'Honda'=>'هوندا','Mazda'=>'مازدا','Peugeot'=>'بيجو','Fiat'=>'فيات','Opel'=>'أوبل','Citroen'=>'سيتروين',
                        'Mitsubishi'=>'ميتسوبيشي','Jeep'=>'جيب','Suzuki'=>'سوزوكي','Land Rover'=>'لاند روفر','Lexus'=>'لكزس','Skoda'=>'سكودا',
                        'Subaru'=>'سوبارو','Seat'=>'سيات','Mini'=>'ميني','Porsche'=>'بورشه','Jaguar'=>'جاغوار',
                        'Chery'=>'شيري','Geely'=>'جيلي','BYD'=>'بي واي دي','MG'=>'إم جي','Haval'=>'هافال','Great Wall'=>'جريت وول'
                    ];
                @endphp
                @foreach($brands as $key=>$label)
                    <option value="{{ $key }}" {{ old('car_brand')==$key?'selected':'' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- 📦 الموديل --}}
        <div>
            <x-label for="car_model" value="الموديل" />
            <x-input id="car_model" name="car_model" type="text" placeholder="مثال: Corolla أو E200"
                     class="w-full mt-1" value="{{ old('car_model') }}" />
        </div>

        {{-- 📅 سنة الصنع --}}
        <div>
            <x-label for="car_year" value="سنة الصنع" />
            <select id="car_year" name="car_year"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر السنة</option>
                @for($y=date('Y'); $y>=1980; $y--)
                    <option value="{{ $y }}" {{ old('car_year')==$y?'selected':'' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>

        {{-- ⛽ نوع الوقود --}}
        <div>
            <x-label for="fuel" value="نوع الوقود" />
            <select id="fuel" name="fuel"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر نوع الوقود</option>
                <option value="Petrol" {{ old('fuel')=='Petrol'?'selected':'' }}>بنزين</option>
                <option value="Diesel" {{ old('fuel')=='Diesel'?'selected':'' }}>ديزل</option>
                <option value="Electric" {{ old('fuel')=='Electric'?'selected':'' }}>كهرباء</option>
                <option value="Hybrid" {{ old('fuel')=='Hybrid'?'selected':'' }}>هجين</option>
            </select>
        </div>

        {{-- ⚙️ ناقل الحركة --}}
        <div>
            <x-label for="gearbox" value="ناقل الحركة" />
            <select id="gearbox" name="gearbox"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر ناقل الحركة</option>
                <option value="Automatic" {{ old('gearbox')=='Automatic'?'selected':'' }}>أوتوماتيك</option>
                <option value="Manual" {{ old('gearbox')=='Manual'?'selected':'' }}>عادي</option>
            </select>
        </div>

        {{-- 🎨 اللون --}}
        <div>
            <x-label for="car_color" value="اللون" />
            <select id="car_color" name="car_color"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر اللون</option>
                @php
                    $colors = ['White'=>'أبيض','Black'=>'أسود','Gray'=>'رمادي','Silver'=>'فضي','Blue'=>'أزرق',
                               'Red'=>'أحمر','Gold'=>'ذهبي','Green'=>'أخضر','Brown'=>'بني',
                               'Beige'=>'بيج','Orange'=>'برتقالي','Yellow'=>'أصفر'];
                @endphp
                @foreach($colors as $key=>$label)
                    <option value="{{ $key }}" {{ old('car_color')==$key?'selected':'' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- 📏 عدد الكيلومترات --}}
        <div>
            <x-label for="car_km" value="عدد الكيلومترات (كم)" />
            <x-input id="car_km" name="car_km" type="number" placeholder="مثال: 85000"
                     class="w-full mt-1" value="{{ old('car_km') }}" />
        </div>

        {{-- ⚡ سعة المحرك --}}
        <div>
            <x-label for="engine_size" value="سعة المحرك (سم³)" />
            <x-input id="engine_size" name="engine_size" type="number"
                     placeholder="مثال: 2000" class="w-full mt-1"
                     value="{{ old('engine_size') }}" />
        </div>

        {{-- 🚪 عدد الأبواب --}}
        <div>
            <x-label for="doors" value="عدد الأبواب" />
            <select id="doors" name="doors"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر العدد</option>
                @foreach([2,3,4,5] as $num)
                    <option value="{{ $num }}" {{ old('doors')==$num?'selected':'' }}>{{ $num }}</option>
                @endforeach
            </select>
        </div>

        {{-- 🚘 نوع الهيكل --}}
        <div>
            <x-label for="body_type" value="نوع الهيكل" />
            <select id="body_type" name="body_type"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر النوع</option>
                <option value="Sedan">سيدان</option>
                <option value="SUV">دفع رباعي</option>
                <option value="Hatchback">هاتشباك</option>
                <option value="Pickup">بيك أب</option>
                <option value="Van">فان</option>
                <option value="Coupe">كوبيه</option>
                <option value="Convertible">كابريوليه</option>
            </select>
        </div>

        {{-- 🏷️ نوع العرض --}}
        <div>
            <x-label for="deal_type" value="نوع العرض" />
            <select id="deal_type" name="deal_type"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="sale">بيع</option>
                <option value="rent">إيجار</option>
            </select>
        </div>

        {{-- 🚘 حالة السيارة --}}
        <div class="flex items-center mt-6">
            <input id="is_new" name="is_new" type="checkbox" value="1"
                   class="rounded border-gray-300 focus:ring-yellow-500 focus:border-yellow-500"
                   {{ old('is_new') ? 'checked' : '' }}>
            <label for="is_new" class="ml-2 text-gray-700">🚘 جديدة</label>
        </div>
    </div>
</div>

{{-- 🛠 تفاصيل الخدمة (يظهر فقط إذا كانت الفئة = خدمات) --}}
<div id="service-fields" class="mt-6 hidden">

    <label class="block text-gray-700 font-semibold mb-2">نوع الخدمة</label>
    <select name="service_type" class="w-full border-gray-300 rounded-xl">
        <option value="">اختر نوع الخدمة</option>

        <!-- 🏠 خدمات منزلية -->
        <option value="cleaning">تنظيف منازل ومكاتب</option>
        <option value="maintenance">صيانة عامة</option>
        <option value="moving">نقل أثاث</option>
        <option value="gardening">تنسيق حدائق</option>
        <option value="pets">رعاية الحيوانات</option>

        <!-- 🚗 خدمات سيارات -->
        <option value="car-mechanic">ميكانيك سيارات</option>
        <option value="car-electric">كهرباء سيارات</option>
        <option value="car-wash">غسيل سيارات</option>
        <option value="cargo">نقل بضائع</option>
        <option value="driver">سائق خاص</option>

        <!-- 🎓 تعليم وتدريب -->
        <option value="private-lessons">دروس خصوصية</option>
        <option value="programming">كورسات برمجة</option>
        <option value="languages">دورات لغات</option>
        <option value="music">تعليم موسيقى</option>
        <option value="fitness">تدريب رياضي</option>

        <!-- 💅 صحة وتجميل -->
        <option value="dentists">أطباء أسنان</option>
        <option value="clinics">عيادات وصيدليات</option>
        <option value="barbers">صالونات حلاقة</option>
        <option value="beauty">مراكز تجميل</option>
        <option value="massage">مساج وعلاج طبيعي</option>

        <!-- 📈 أعمال وخدمات -->
        <option value="lawyers">محاماة</option>
        <option value="accounting">محاسبة</option>
        <option value="marketing">تسويق رقمي</option>
        <option value="design">تصميم وغرافيك</option>
        <option value="photography">تصوير ومونتاج</option>

        <!-- 📑 خدمات طلابية -->
        <option value="university">تسجيل جامعي</option>
        <option value="translation">ترجمة</option>
        <option value="research">كتابة أبحاث</option>
        <option value="documents">تخليص معاملات</option>
    </select>
</div>

<script>
    // ✅ إظهار/إخفاء تفاصيل الخدمات تلقائياً حسب اختيار الفئة
    document.querySelector('[name="category"]').addEventListener('change', function () {
        document.getElementById('service-fields').classList.toggle('hidden', this.value !== 'services');
    });
</script>

    {{-- اسم مقدم الخدمة --}}
    <div>
        <x-label for="provider_name" value="اسم مقدم الخدمة (اختياري)" />
        <x-input name="provider_name" id="provider_name"
                 class="w-full mt-1 border-gray-300 rounded-md shadow-sm" />
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
