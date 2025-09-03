<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">

        <h1 class="text-3xl font-bold text-center text-yellow-600 mb-10">
            🛠️ {{ __('messages.services') }}
        </h1>

        {{-- 🏠 خدمات منزلية --}}
        <h2 class="text-xl font-semibold text-gray-800 mb-4">🏠 خدمات منزلية</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <x-service-card icon="🧹" title="تنظيف منازل ومكاتب" desc="أعمال تنظيف ورعاية متكاملة"
                link="{{ route('ads.services', ['subcategory' => 'cleaning']) }}"/>
            <x-service-card icon="🔧" title="صيانة عامة" desc="كهرباء – سباكة – دهان"
                link="{{ route('ads.services', ['subcategory' => 'maintenance']) }}"/>
            <x-service-card icon="🛋️" title="نقل أثاث" desc="تحميل وتغليف ونقل داخلي"
                link="{{ route('ads.services', ['subcategory' => 'moving']) }}"/>
            <x-service-card icon="🌳" title="تنسيق حدائق" desc="زراعة وصيانة حدائق"
                link="{{ route('ads.services', ['subcategory' => 'gardening']) }}"/>
            <x-service-card icon="🐾" title="رعاية الحيوانات" desc="خدمات عناية بالحيوانات الأليفة"
                link="{{ route('ads.services', ['subcategory' => 'pets']) }}"/>
        </div>

        {{-- 🚗 خدمات سيارات ونقل --}}
        <h2 class="text-xl font-semibold text-gray-800 mb-4">🚗 خدمات سيارات ونقل</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <x-service-card icon="🛠️" title="ميكانيك سيارات" desc="整修 سيارات ودراجات"
                link="{{ route('ads.services', ['subcategory' => 'car-mechanic']) }}"/>
            <x-service-card icon="🔋" title="كهرباء سيارات" desc="فحص وإصلاح كهرباء السيارات"
                link="{{ route('ads.services', ['subcategory' => 'car-electric']) }}"/>
            <x-service-card icon="🧴" title="غسيل سيارات" desc="غسيل وتلميع داخلي وخارجي"
                link="{{ route('ads.services', ['subcategory' => 'car-wash']) }}"/>
            <x-service-card icon="🚚" title="نقل بضائع" desc="شحن داخلي وبضائع كبيرة"
                link="{{ route('ads.services', ['subcategory' => 'cargo']) }}"/>
            <x-service-card icon="🚖" title="سائق خاص / تكسي" desc="سائقين موثوقين للتوصيل"
                link="{{ route('ads.services', ['subcategory' => 'driver']) }}"/>
        </div>

        {{-- 🎓 تعليم وتدريب --}}
        <h2 class="text-xl font-semibold text-gray-800 mb-4">🎓 تعليم وتدريب</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <x-service-card icon="📚" title="دروس خصوصية" desc="مدرسين مختصين في كافة المواد"
                link="{{ route('ads.services', ['subcategory' => 'private-lessons']) }}"/>
            <x-service-card icon="💻" title="كورسات برمجة" desc="تعلم برمجة وتصميم مواقع"
                link="{{ route('ads.services', ['subcategory' => 'programming']) }}"/>
            <x-service-card icon="🗣️" title="دورات لغات" desc="إنكليزي – تركي – فرنسي"
                link="{{ route('ads.services', ['subcategory' => 'languages']) }}"/>
            <x-service-card icon="🎶" title="تعليم موسيقى" desc="عود، غيتار، بيانو"
                link="{{ route('ads.services', ['subcategory' => 'music']) }}"/>
            <x-service-card icon="🏋️" title="تدريب رياضي" desc="مدرب شخصي ولياقة"
                link="{{ route('ads.services', ['subcategory' => 'fitness']) }}"/>
        </div>

        {{-- 🧑‍⚕️ صحة وتجميل --}}
        <h2 class="text-xl font-semibold text-gray-800 mb-4">🧑‍⚕️ صحة وتجميل</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <x-service-card icon="🦷" title="أطباء أسنان" desc="أفضل عيادات الأسنان"
                link="{{ route('ads.services', ['subcategory' => 'dentists']) }}"/>
            <x-service-card icon="🏥" title="عيادات وصيدليات" desc="خدمات طبية شاملة"
                link="{{ route('ads.services', ['subcategory' => 'clinics']) }}"/>
            <x-service-card icon="💇" title="صالونات حلاقة" desc="رجالي ونسائي"
                link="{{ route('ads.services', ['subcategory' => 'barbers']) }}"/>
            <x-service-card icon="💅" title="مراكز تجميل" desc="عناية بالشعر والبشرة"
                link="{{ route('ads.services', ['subcategory' => 'beauty']) }}"/>
            <x-service-card icon="🧖" title="مساج وعلاج طبيعي" desc="جلسات علاجية وراحة"
                link="{{ route('ads.services', ['subcategory' => 'massage']) }}"/>
        </div>

        {{-- 📈 أعمال وخدمات --}}
        <h2 class="text-xl font-semibold text-gray-800 mb-4">📈 أعمال وخدمات</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <x-service-card icon="⚖️" title="محاماة" desc="مكاتب محامين واستشارات"
                link="{{ route('ads.services', ['subcategory' => 'lawyers']) }}"/>
            <x-service-card icon="🏦" title="محاسبة" desc="إدارة الحسابات والضرائب"
                link="{{ route('ads.services', ['subcategory' => 'accounting']) }}"/>
            <x-service-card icon="📢" title="تسويق رقمي" desc="إعلانات إلكترونية"
                link="{{ route('ads.services', ['subcategory' => 'marketing']) }}"/>
            <x-service-card icon="🎨" title="تصميم وغرافيك" desc="شعارات، هويات بصرية"
                link="{{ route('ads.services', ['subcategory' => 'design']) }}"/>
            <x-service-card icon="📷" title="تصوير ومونتاج" desc="فيديو وصور احترافية"
                link="{{ route('ads.services', ['subcategory' => 'photography']) }}"/>
        </div>

        {{-- 📑 خدمات طلابية وترجمة --}}
        <h2 class="text-xl font-semibold text-gray-800 mb-4">📑 خدمات طلابية وترجمة</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <x-service-card icon="🎓" title="تسجيل جامعي" desc="خدمات طلابية محلية ودولية"
                link="{{ route('ads.services', ['subcategory' => 'university']) }}"/>
            <x-service-card icon="📝" title="ترجمة" desc="مترجمين معتمدين لجميع اللغات"
                link="{{ route('ads.services', ['subcategory' => 'translation']) }}"/>
            <x-service-card icon="📚" title="كتابة أبحاث" desc="مساعدة أكاديمية"
                link="{{ route('ads.services', ['subcategory' => 'research']) }}"/>
            <x-service-card icon="🏢" title="تخليص معاملات" desc="خدمات حكومية وتجارية"
                link="{{ route('ads.services', ['subcategory' => 'documents']) }}"/>
        </div>

    </div>
</x-app-layout>
