{{-- resources/views/ads/partials/filters.blade.php --}}
<form id="filterBox" method="GET" action="{{ route('ads.index') }}" 
      class="hidden bg-white shadow-md rounded-2xl p-6 mb-12 w-full max-w-6xl mx-auto"
      x-data="{ category: '{{ request('category') ?? '' }}' }">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- 🌍 اختيار المدينة --}}
        <select name="city" class="w-full p-3 border rounded-xl text-sm">
            <option value="">{{ __('messages.select_city') }}</option>
            @foreach(['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','درعا','السويداء','القنيطرة','إدلب','الرقة','دير الزور','الحسكة','تركيا'] as $city)
                <option value="{{ $city }}" {{ request('city')==$city?'selected':'' }}>{{ $city }}</option>
            @endforeach
        </select>

        {{-- 📂 التصنيف --}}
        <select name="category" x-model="category" class="w-full p-3 border rounded-xl text-sm">
            <option value="">{{ __('messages.select_category') }}</option>
            <option value="realestate" {{ request('category')=='realestate'?'selected':'' }}>🏠 {{ __('messages.real_estate') }}</option>
            <option value="cars" {{ request('category')=='cars'?'selected':'' }}>🚗 {{ __('messages.cars') }}</option>
            <option value="services" {{ request('category')=='services'?'selected':'' }}>🛠️ {{ __('messages.services') }}</option>
        </select>

        {{-- 💰 السعر --}}
        <input type="number" name="price_min" placeholder="{{ __('messages.price_from') }}" class="w-full p-3 border rounded-xl text-sm" value="{{ request('price_min') }}">
        <input type="number" name="price_max" placeholder="{{ __('messages.price_to') }}" class="w-full p-3 border rounded-xl text-sm" value="{{ request('price_max') }}">
    </div>

    {{-- 🏠 فلترة العقارات --}}
    <div x-show="category === 'realestate'" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <select name="subcategory" class="w-full p-3 border rounded-xl text-sm">
            <option value="">اختر نوع العقار</option>
            <option value="residential" {{ request('subcategory')=='residential'?'selected':'' }}>سكني</option>
            <option value="shop" {{ request('subcategory')=='shop'?'selected':'' }}>محل تجاري</option>
            <option value="land" {{ request('subcategory')=='land'?'selected':'' }}>أرض</option>
            <option value="villa" {{ request('subcategory')=='villa'?'selected':'' }}>فيلا</option>
            <option value="office" {{ request('subcategory')=='office'?'selected':'' }}>مكتب</option>
            <option value="building" {{ request('subcategory')=='building'?'selected':'' }}>بناء</option>
        </select>
        <select name="deal_type" class="w-full p-3 border rounded-xl text-sm">
            <option value="">نوع الصفقة</option>
            <option value="sale" {{ request('deal_type')=='sale'?'selected':'' }}>بيع</option>
            <option value="rent" {{ request('deal_type')=='rent'?'selected':'' }}>إيجار</option>
        </select>
        <select name="rooms" class="w-full p-3 border rounded-xl text-sm">
            <option value="">عدد الغرف</option>
            @for ($i=1; $i<=10; $i++)
                <option value="{{ $i }}+1" {{ request('rooms')=="$i+1"?'selected':'' }}>{{ $i }}+1</option>
            @endfor
        </select>
        <input type="number" name="building_age" placeholder="عمر البناء" class="w-full p-3 border rounded-xl text-sm" value="{{ request('building_age') }}">
        <input type="number" name="area_min" placeholder="المساحة من (م²)" class="w-full p-3 border rounded-xl text-sm" value="{{ request('area_min') }}">
        <input type="number" name="area_max" placeholder="المساحة إلى (م²)" class="w-full p-3 border rounded-xl text-sm" value="{{ request('area_max') }}">
    </div>

    {{-- 🚗 فلترة السيارات --}}
    <div x-show="category === 'cars'" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <select name="car_brand" class="w-full p-3 border rounded-xl text-sm">
            <option value="">اختر الشركة المصنعة</option>
            @foreach(['Audi','BMW','Mercedes-Benz','Toyota','Hyundai','Kia','Renault','Nissan','Volkswagen','Volvo','Chevrolet','Ford','Honda','Mazda'] as $brand)
                <option value="{{ $brand }}" {{ request('car_brand')==$brand?'selected':'' }}>{{ $brand }}</option>
            @endforeach
        </select>
        <select name="car_year" class="w-full p-3 border rounded-xl text-sm">
            <option value="">اختر سنة الصنع</option>
            @for ($y = date('Y'); $y >= 1980; $y--)
                <option value="{{ $y }}" {{ request('car_year')==$y?'selected':'' }}>{{ $y }}</option>
            @endfor
        </select>
        <select name="fuel" class="w-full p-3 border rounded-xl text-sm">
            <option value="">نوع الوقود</option>
            <option value="بنزين" {{ request('fuel')=='بنزين'?'selected':'' }}>بنزين</option>
            <option value="ديزل" {{ request('fuel')=='ديزل'?'selected':'' }}>ديزل</option>
            <option value="كهرباء" {{ request('fuel')=='كهرباء'?'selected':'' }}>كهرباء</option>
            <option value="هجين" {{ request('fuel')=='هجين'?'selected':'' }}>هجين</option>
        </select>
        <select name="gearbox" class="w-full p-3 border rounded-xl text-sm">
            <option value="">ناقل الحركة</option>
            <option value="أوتوماتيك" {{ request('gearbox')=='أوتوماتيك'?'selected':'' }}>أوتوماتيك</option>
            <option value="عادي" {{ request('gearbox')=='عادي'?'selected':'' }}>عادي</option>
        </select>
        <input type="text" name="car_color" placeholder="اللون" class="w-full p-3 border rounded-xl text-sm" value="{{ request('car_color') }}">
        <input type="number" name="car_km_max" placeholder="المسافة القصوى (كم)" class="w-full p-3 border rounded-xl text-sm" value="{{ request('car_km_max') }}">
    </div>

    {{-- 🛠️ فلترة الخدمات --}}
    <div x-show="category === 'services'" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <input type="text" name="service_type" placeholder="نوع الخدمة" class="w-full p-3 border rounded-xl text-sm" value="{{ request('service_type') }}">
        <input type="text" name="provider_name" placeholder="اسم المزود" class="w-full p-3 border rounded-xl text-sm" value="{{ request('provider_name') }}">
    </div>

    {{-- ⭐ حالة الإعلان + الترتيب --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <select name="featured" class="w-full p-3 border rounded-xl text-sm">
            <option value="">{{ __('messages.featured_status') }}</option>
            <option value="1" {{ request('featured')=='1'?'selected':'' }}>⭐ {{ __('messages.featured') }}</option>
            <option value="0" {{ request('featured')=='0'?'selected':'' }}>⚪ {{ __('messages.normal') }}</option>
        </select>
        <select name="sort" class="w-full p-3 border rounded-xl text-sm">
            <option value="latest" {{ request('sort')=='latest'?'selected':'' }}>🆕 {{ __('messages.latest') }}</option>
            <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>💰 {{ __('messages.price_high') }}</option>
            <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>💰 {{ __('messages.price_low') }}</option>
        </select>
    </div>

    <div class="flex justify-end mt-4 gap-3">
        <a href="{{ route('ads.index') }}" class="bg-gray-200 px-6 py-3 rounded-xl hover:bg-gray-300 transition">
            <i class="fas fa-undo"></i> {{ __('messages.reset_filters') }}
        </a>
        <button type="submit" class="bg-yellow-500 text-white px-6 py-3 rounded-xl hover:bg-yellow-600 transition">
            <i class="fas fa-search"></i> {{ __('messages.search') }}
        </button>
    </div>
</form>

