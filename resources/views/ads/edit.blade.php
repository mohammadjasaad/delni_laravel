{{-- resources/views/ads/edit.blade.php --}}
<x-main-layout>
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- ✅ العنوان --}}
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">
            {{ __('messages.edit_ad') }}
        </h1>

        {{-- ✅ الأخطاء --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-800 p-4 rounded shadow">
                <ul class="list-disc pl-6 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ نموذج التعديل --}}
        <form action="{{ route('ads.update', $ad->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow space-y-6">
            @csrf
            @method('PUT')

            {{-- 📝 العنوان --}}
            <div>
                <x-label for="title" :value="__('messages.title')" />
                <x-input id="title" type="text" name="title" value="{{ $ad->title }}" class="w-full mt-1" required />
            </div>

            {{-- 🧾 الوصف --}}
            <div>
                <x-label for="description" :value="__('messages.description')" />
                <textarea id="description" name="description" rows="4" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>{{ $ad->description }}</textarea>
            </div>

            {{-- 💰 السعر --}}
            <div>
                <x-label for="price" :value="__('messages.price')" />
                <x-input id="price" type="number" name="price" value="{{ $ad->price }}" class="w-full mt-1" required />
            </div>

            {{-- 🏙️ المدينة --}}
            <div>
                <x-label for="city" :value="__('messages.city')" />
                <select id="city" name="city" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" @if($ad->city == $city) selected @endif>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 🗂️ التصنيف --}}
            <div>
                <x-label for="category" :value="__('messages.category')" />
                <select id="category" name="category" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" @if($ad->category == $category) selected @endif>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
{{-- 🏠 خصائص العقارات --}}
@if($ad->category === 'realestate')
<div class="space-y-4 mt-6 bg-white shadow-md rounded-2xl p-6">
    <h2 class="font-bold text-lg mb-4 flex items-center gap-2 text-gray-800">
        <i class="fas fa-building text-yellow-500"></i> تفاصيل العقار
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        {{-- 🏷️ نوع العرض --}}
        <div>
            <x-label for="deal_type" value="نوع العرض" />
            <select id="deal_type" name="deal_type"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر نوع العرض</option>
                <option value="sale" @if($ad->deal_type == 'sale') selected @endif>بيع 🏷️</option>
                <option value="rent" @if($ad->deal_type == 'rent') selected @endif>إيجار 🏠</option>
            </select>
        </div>

        {{-- 🏢 نوع العقار --}}
        <div>
            <x-label for="subcategory" value="نوع العقار" />
            <select id="subcategory" name="subcategory"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر نوع العقار</option>
                <option value="residential" @if($ad->subcategory == 'residential') selected @endif>سكني</option>
                <option value="commercial" @if($ad->subcategory == 'commercial') selected @endif>تجاري</option>
                <option value="land" @if($ad->subcategory == 'land') selected @endif>أرض</option>
                <option value="villa" @if($ad->subcategory == 'villa') selected @endif>فيلا</option>
                <option value="office" @if($ad->subcategory == 'office') selected @endif>مكتب</option>
                <option value="building" @if($ad->subcategory == 'building') selected @endif>بناء كامل</option>
            </select>
        </div>

        {{-- 🚪 عدد الغرف --}}
        <div>
            <x-label for="rooms" value="عدد الغرف" />
            <select id="rooms" name="rooms"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر عدد الغرف</option>
                <option value="1+0" @if($ad->rooms == '1+0') selected @endif>1+0</option>
                <option value="1+1" @if($ad->rooms == '1+1') selected @endif>1+1</option>
                <option value="2+1" @if($ad->rooms == '2+1') selected @endif>2+1</option>
                <option value="3+1" @if($ad->rooms == '3+1') selected @endif>3+1</option>
                <option value="4+1" @if($ad->rooms == '4+1') selected @endif>4+1</option>
                <option value="5+1" @if($ad->rooms == '5+1') selected @endif>5+1</option>
                <option value="6+1" @if($ad->rooms == '6+1') selected @endif>6+1</option>
            </select>
        </div>

        {{-- 🚿 عدد الحمامات --}}
        <div>
            <x-label for="bathrooms" value="عدد الحمامات" />
            <select id="bathrooms" name="bathrooms"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر عدد الحمامات</option>
                <option value="1" @if($ad->bathrooms == '1') selected @endif>1</option>
                <option value="2" @if($ad->bathrooms == '2') selected @endif>2</option>
                <option value="3" @if($ad->bathrooms == '3') selected @endif>3</option>
                <option value="4" @if($ad->bathrooms == '4') selected @endif>4</option>
                <option value="5" @if($ad->bathrooms == '5') selected @endif>5</option>
            </select>
        </div>

        {{-- 📏 المساحة الإجمالية --}}
        <div>
            <x-label for="area_total" value="المساحة الإجمالية (م²)" />
            <x-input id="area_total" name="area_total" type="number"
                     placeholder="مثال: 150" value="{{ $ad->area_total }}" class="w-full mt-1" />
        </div>

        {{-- 📐 المساحة الصافية --}}
        <div>
            <x-label for="area_net" value="المساحة الصافية (م²)" />
            <x-input id="area_net" name="area_net" type="number"
                     placeholder="مثال: 120" value="{{ $ad->area_net }}" class="w-full mt-1" />
        </div>

        {{-- 🧱 الطابق --}}
        <div>
            <x-label for="floor" value="الطابق" />
            <select id="floor" name="floor"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر الطابق</option>
                <option value="ground" @if($ad->floor == 'ground') selected @endif>الأرضي</option>
                <option value="1" @if($ad->floor == '1') selected @endif>الأول</option>
                <option value="2" @if($ad->floor == '2') selected @endif>الثاني</option>
                <option value="3" @if($ad->floor == '3') selected @endif>الثالث</option>
                <option value="4" @if($ad->floor == '4') selected @endif>الرابع</option>
                <option value="5" @if($ad->floor == '5') selected @endif>الخامس</option>
                <option value="6+" @if($ad->floor == '6+') selected @endif>أعلى من الخامس</option>
            </select>
        </div>

        {{-- 🏗️ عمر البناء --}}
        <div>
            <x-label for="building_age" value="عمر البناء" />
            <select id="building_age" name="building_age"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر عمر البناء</option>
                <option value="new" @if($ad->building_age == 'new') selected @endif>جديد</option>
                <option value="1-5" @if($ad->building_age == '1-5') selected @endif>1 - 5 سنوات</option>
                <option value="6-10" @if($ad->building_age == '6-10') selected @endif>6 - 10 سنوات</option>
                <option value="10+" @if($ad->building_age == '10+') selected @endif>أكثر من 10 سنوات</option>
            </select>
        </div>

        {{-- 🔥 نوع التدفئة --}}
        <div>
            <x-label for="heating_type" value="نوع التدفئة" />
            <select id="heating_type" name="heating_type"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">اختر نوع التدفئة</option>
                <option value="central" @if($ad->heating_type == 'central') selected @endif>مركزي</option>
                <option value="gas" @if($ad->heating_type == 'gas') selected @endif>غاز</option>
                <option value="electric" @if($ad->heating_type == 'electric') selected @endif>كهرباء</option>
                <option value="diesel" @if($ad->heating_type == 'diesel') selected @endif>مازوت</option>
                <option value="none" @if($ad->heating_type == 'none') selected @endif>بدون تدفئة</option>
            </select>
        </div>

        {{-- 🛗 مصعد --}}
        <div class="flex items-center">
            <input id="has_elevator" name="has_elevator" type="checkbox" value="1"
                   @if($ad->has_elevator) checked @endif
                   class="rounded border-gray-300 focus:ring-yellow-500 focus:border-yellow-500">
            <label for="has_elevator" class="ml-2 text-gray-700">مصعد</label>
        </div>

        {{-- 🚗 موقف سيارات --}}
        <div class="flex items-center">
            <input id="has_parking" name="has_parking" type="checkbox" value="1"
                   @if($ad->has_parking) checked @endif
                   class="rounded border-gray-300 focus:ring-yellow-500 focus:border-yellow-500">
            <label for="has_parking" class="ml-2 text-gray-700">موقف سيارات</label>
        </div>
    </div>
</div>
@endif

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

            {{-- 🖼️ الصور الجديدة --}}
            <div>
                <x-label for="images" :value="__('messages.images')" />
                <input type="file" name="images[]" id="images" multiple class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" />
                <p class="text-sm text-gray-500 mt-1">{{ __('messages.upload_new_images_note') }}</p>
            </div>

            {{-- ✅ الصور الحالية --}}
            @php
                $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
            @endphp

            @if($images && count($images) > 0)
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">{{ __('messages.current_images') }}</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($images as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="Image" class="w-full h-32 object-cover rounded shadow">
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ✅ زر التحديث --}}
            <div>
                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-3 rounded-xl">
                    {{ __('messages.update') }}
                </button>
            </div>
        </form>
    </div>
</x-main-layout>
