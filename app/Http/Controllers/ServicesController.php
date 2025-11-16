<?php

namespace App\Http\Controllers;

use App\Models\ServiceBanner;
use App\Models\Ad;
use App\Models\ServiceRating;

class ServicesController extends Controller
{

public function index()
{
    $service_banners = ServiceBanner::latest()->get();

    $groups = [
        "🏠 خدمات منزلية" => [
            ["title" => "تنظيف", "sub" => "cleaning"],
            ["title" => "صيانة عامة", "sub" => "maintenance"],
            ["title" => "نقل أثاث", "sub" => "moving"],
            ["title" => "حدائق", "sub" => "gardening"],
            ["title" => "رعاية حيوانات", "sub" => "pets"],
        ],
        "🚗 خدمات سيارات" => [
            ["title" => "ميكانيك سيارات", "sub" => "car-mechanic"],
            ["title" => "كهرباء سيارات", "sub" => "car-electric"],
            ["title" => "مغسلة سيارات", "sub" => "car-wash"],
            ["title" => "شحن بضائع", "sub" => "cargo"],
            ["title" => "سائق خاص", "sub" => "driver"],
        ],
        "🎓 تعليم وتدريب" => [
            ["title" => "دروس خصوصية", "sub" => "private-lessons"],
            ["title" => "لغات", "sub" => "languages"],
            ["title" => "برمجة", "sub" => "programming"],
            ["title" => "موسيقى", "sub" => "music"],
            ["title" => "لياقة وتدريب", "sub" => "fitness"],
        ],
        "💈 صحة وتجميل" => [
            ["title" => "أطباء أسنان", "sub" => "dentists"],
            ["title" => "عيادات", "sub" => "clinics"],
            ["title" => "حلاقة رجالية / نسائية", "sub" => "barbers"],
            ["title" => "مراكز تجميل", "sub" => "beauty"],
            ["title" => "جلسات مساج", "sub" => "massage"],
        ],
        "📈 أعمال وخدمات" => [
            ["title" => "محامين", "sub" => "lawyers"],
            ["title" => "محاسبة", "sub" => "accounting"],
            ["title" => "تسويق", "sub" => "marketing"],
            ["title" => "تصميم", "sub" => "design"],
            ["title" => "تصوير", "sub" => "photography"],
        ],
        "🎓 خدمات طلابية" => [
            ["title" => "خدمات جامعية", "sub" => "university"],
            ["title" => "ترجمة", "sub" => "translation"],
            ["title" => "بحوث علمية", "sub" => "research"],
            ["title" => "معاملات وأوراق", "sub" => "documents"],
        ],
    ];

    return view('services.index', compact('groups', 'service_banners'));
}

public function show($subcategory)
{
    $allCities = \App\Models\Ad::whereNotNull('city')
        ->distinct()->pluck('city')->sort();

    $adsQuery = \App\Models\Ad::where('subcategory', $subcategory)
        ->whereNotNull('lat')->whereNotNull('lng');

    // ✅ فلترة حسب المدينة
    if (request('city')) {
        $adsQuery->where('city', request('city'));
    }

    // ✅ فلترة حسب السعر
    if (request('min_price')) {
        $adsQuery->where('price', '>=', request('min_price'));
    }
    if (request('max_price')) {
        $adsQuery->where('price', '<=', request('max_price'));
    }

// ✅ ترتيب حسب السعر
if (request('sort') == 'price_asc') {
    $adsQuery->orderBy('price', 'asc');
} elseif (request('sort') == 'price_desc') {
    $adsQuery->orderBy('price', 'desc');
}

// ✅ سحب النتائج بعد تطبيق الفلاتر والترتيب
$adsWithLocation = $adsQuery->get();

// ✅ تقييم المستخدم الحالي إن وجد
$userRating = null;
if (auth()->check()) {
    $userRating = \App\Models\ServiceRating::where('subcategory', $subcategory)
        ->where('user_id', auth()->id())
        ->first();
}

    return view('services.show', [
        'subcategory' => $subcategory,
        'serviceTitle' => $this->serviceNames[$subcategory] ?? $subcategory,
        'adsWithLocation' => $adsWithLocation,
        'serviceRatings' => ServiceRating::where('subcategory', $subcategory)->latest()->get(),
        'averageRating' => ServiceRating::where('subcategory', $subcategory)->avg('stars') ?? 0,
        'ratingsCount' => ServiceRating::where('subcategory', $subcategory)->count(),
        'averagePrice' => $adsWithLocation->avg('price') ?? 0,
        'banner' => $this->getBanner($subcategory),
        'allCities' => $allCities,

    // ✅ أضف هذا السطر
    'userRating' => $userRating,
    ]);
}

    // 🟡 أسماء الخدمات (يمكنك إضافة المزيد لاحقاً)
    private function mapServiceName($sub)
    {
        return [
            'cleaning' => 'تنظيف منازل ومكاتب',
            'barbers' => 'صالونات حلاقة',
            'beauty' => 'مراكز تجميل',
            'maintenance' => 'صيانة عامة',
            'driver' => 'سائق خاص',
            'insurance' => 'تأمين سيارات',
            'transfer' => 'نقل ملكية سيارات',
        ][$sub] ?? $sub;
    }
// ✅ اختيار صورة بانر حسب نوع الخدمة
private function getBanner($subcategory)
{
    $banners = [
        'cleaning'   => asset('images/services/cleaning.jpg'),
        'barbers'    => asset('images/services/barbers.jpg'),
        'beauty'     => asset('images/services/beauty.jpg'),
        'maintenance'=> asset('images/services/maintenance.jpg'),
        'driver'     => asset('images/services/driver.jpg'),
        'insurance'  => asset('images/services/insurance.jpg'),
        'moving'     => asset('images/services/moving.jpg'),
    ];

    // إذا لم يكن هناك صورة محددة - استخدم صورة افتراضية
    return $banners[$subcategory] ?? asset('images/services/default.jpg');
}

}
