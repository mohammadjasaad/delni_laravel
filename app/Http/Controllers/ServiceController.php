<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // ✅ صفحة جميع الخدمات
    public function index()
    {
        $groups = [
            'خدمات منزلية 🏠' => [
                ['title' => 'تنظيف المنازل', 'sub' => 'cleaning'],
                ['title' => 'صيانة عامة', 'sub' => 'maintenance'],
                ['title' => 'نقل عفش', 'sub' => 'moving'],
                ['title' => 'تنسيق حدائق', 'sub' => 'gardening'],
                ['title' => 'رعاية الحيوانات الأليفة', 'sub' => 'pets'],
            ],

            'خدمات سيارات 🚗' => [
                ['title' => 'ميكانيك سيارات', 'sub' => 'car-mechanic'],
                ['title' => 'كهرباء سيارات', 'sub' => 'car-electric'],
                ['title' => 'غسيل سيارات', 'sub' => 'car-wash'],
                ['title' => 'نقل بضائع', 'sub' => 'cargo'],
                ['title' => 'سائق خاص', 'sub' => 'driver'],
            ],

            'تعليم وتدريب 🎓' => [
                ['title' => 'دروس خصوصية', 'sub' => 'private-lessons'],
                ['title' => 'برمجة وتطوير', 'sub' => 'programming'],
                ['title' => 'تعليم لغات', 'sub' => 'languages'],
                ['title' => 'تعليم موسيقى', 'sub' => 'music'],
                ['title' => 'مدرب لياقة', 'sub' => 'fitness'],
            ],

            'صحة وتجميل 💅' => [
                ['title' => 'طب الأسنان', 'sub' => 'dentists'],
                ['title' => 'عيادات طبية', 'sub' => 'clinics'],
                ['title' => 'صالونات حلاقة', 'sub' => 'barbers'],
                ['title' => 'مراكز تجميل', 'sub' => 'beauty'],
                ['title' => 'مساج واسترخاء', 'sub' => 'massage'],
            ],

            'أعمال وخدمات 📈' => [
                ['title' => 'محامين', 'sub' => 'lawyers'],
                ['title' => 'محاسبين', 'sub' => 'accounting'],
                ['title' => 'تسويق وإعلانات', 'sub' => 'marketing'],
                ['title' => 'تصميم جرافيك', 'sub' => 'design'],
                ['title' => 'تصوير فوتوغرافي', 'sub' => 'photography'],
            ],

            'خدمات طلابية 🎓' => [
                ['title' => 'شؤون جامعية', 'sub' => 'university'],
                ['title' => 'ترجمة', 'sub' => 'translation'],
                ['title' => 'إعداد بحوث', 'sub' => 'research'],
                ['title' => 'معاملات وأوراق رسمية', 'sub' => 'documents'],
            ],
        ];

        return view('services.index', compact('groups'));
    }

    // ✅ صفحة خدمات حسب نوع معين
    public function byType($service_type)
    {
        $services = Ad::where('category', 'services')
                      ->where('service_type', $service_type)
                      ->latest()
                      ->paginate(20);

        return view('services.list', compact('services', 'service_type'));
    }
}
