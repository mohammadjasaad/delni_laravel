<?php

use Illuminate\Support\Facades\Route;

# ---------------- Controllers عامة ----------------
use App\Http\Controllers\Auth\WhatsappAuthController;
use App\Http\Controllers\PhoneLoginController;
use App\Http\Controllers\ServiceRatingController;
use App\Http\Controllers\MallController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\{
    AdController, ContactController, DashboardController,
    EmergencyServiceController, EmergencyReportController,
    DriverController,
    OrderController, RatingController, MapController,
    FavoriteController, ReportController,
    AdminController,
    Admin\EmergencyReportController as AdminEmergencyReportController,
    AdminEmergencyController,
    SupportTicketController,
    Admin\SupportTicketAdminController,
    Dashboard\StatisticsController,
    Admin\DashboardController as AdminDashboard,
    EmergencyStatisticsController
};

# ---------------- 🚖 Delni Taxi ----------------
use App\Http\Controllers\Taxi\TaxiController;
use App\Http\Controllers\Taxi\TaxiOrderController;
use App\Http\Controllers\Taxi\TaxiMessageController;
use App\Http\Controllers\Taxi\TaxiChatController;
use App\Http\Controllers\Taxi\DriverApiController;
# ------------------ 🏠 الصفحة الرئيسية ------------------
Route::get('/', [AdController::class, 'index'])->name('home');

# 🛍️ دلني مول
Route::prefix('mall')->group(function () {
    # 🏬 كل المتاجر
    Route::get('/', [MallController::class, 'index'])->name('mall.index');
    Route::get('/create', [MallController::class, 'create'])->middleware('auth')->name('mall.create');
    Route::post('/', [MallController::class, 'store'])->middleware('auth')->name('mall.store');

    # 🏬 متجر محدد
    Route::prefix('{store}')->group(function () {

        # 👁️ عرض المتجر
        Route::get('/', [MallController::class, 'show'])->name('mall.show');

# ---------------- 🛒 منتجات المتجر ----------------
Route::get('/products', [ProductController::class, 'index'])->name('mall.products.index');

Route::middleware('auth')->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('mall.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('mall.products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('mall.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('mall.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('mall.products.destroy');
});

Route::get('/products/{product}', [ProductController::class, 'show'])->name('mall.products.show');

        # ---------------- 📢 إعلانات المتجر ----------------
        Route::get('/ads', [StoreController::class, 'ads'])->name('mall.ads.index');
        Route::get('/ads/{ad}', [StoreController::class, 'showAd'])->name('mall.ads.show');

            Route::middleware(['auth', 'blockBanned'])->group(function () {
            Route::get('/ads/create', [StoreController::class, 'createAd'])->name('mall.ads.create');
            Route::post('/ads', [StoreController::class, 'storeAd'])->name('mall.ads.store');
            Route::get('/ads/{ad}/edit', [StoreController::class, 'editAd'])->name('mall.ads.edit');
            Route::put('/ads/{ad}', [StoreController::class, 'updateAd'])->name('mall.ads.update');
            Route::delete('/ads/{ad}', [StoreController::class, 'destroyAd'])->name('mall.ads.destroy');
        });

        # ---------------- ⚙️ لوحة تحكم المتجر ----------------
        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('mall.dashboard');
            Route::get('/edit', [StoreController::class, 'edit'])->name('mall.edit');
            Route::put('/', [StoreController::class, 'update'])->name('mall.update');
            Route::delete('/', [StoreController::class, 'destroy'])->name('mall.destroy'); // ✅ مسار الحذف
        });
    });
});

# ==================== 🛒 السلة ====================
Route::middleware('auth')->group(function () {
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');

    Route::post('/mall/{store}/{product}/add-to-cart', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');

    Route::post('/cart/{item}/increase', [\App\Http\Controllers\CartController::class, 'increase'])->name('cart.increase');
    Route::post('/cart/{item}/decrease', [\App\Http\Controllers\CartController::class, 'decrease'])->name('cart.decrease');

    Route::delete('/cart/{item}/remove', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
});

# ------------------ 📄 صفحات ثابتة ------------------
Route::view('/about', 'about')->name('about');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/faq', 'pages.faq')->name('faq');

# ------------------ 📞 اتصل بنا ------------------
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

# ------------------ 🔑 تسجيل الدخول والتسجيل ------------------
require __DIR__.'/auth.php';
Route::get('/logged-out', fn() => view('auth.logged-out'))->name('logged-out');

# ✅ صفحة تسجيل الدخول الموحدة الجديدة (Delni)
Route::get('/login', function () {
    return view('auth.unified-login');
})->name('login');

# ------------------ 🌐 تغيير اللغة ------------------
Route::get('/change-lang/{lang}', function ($lang) {
    if (in_array($lang, ['ar', 'en'])) session(['locale' => $lang]);
    return back();
})->name('change.lang');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) session(['locale' => $locale]);
    return back();
})->name('lang.switch');

Route::get('/change-language/{lang}', function ($lang) {
    $locale = in_array($lang, ['ar', 'en']) ? $lang : app()->getLocale();
    return redirect()->route('lang.switch', $locale);
})->name('change-language');

# ------------------ 📢 الإعلانات ------------------
Route::prefix('ads')->group(function () {
    Route::get('/', [AdController::class, 'index'])->name('ads.index');
    Route::get('/create', [AdController::class, 'create'])->middleware('auth')->name('ads.create');
    Route::post('/', [AdController::class, 'store'])->middleware('auth')->name('ads.store');

    # 🗺️ بيانات الإعلانات للخريطة
    Route::get('/map-data', [AdController::class, 'mapData'])->name('ads.mapData');

    # 👁️ عرض إعلان
    Route::get('/{slug}', [AdController::class, 'show'])->name('ads.show');

    # ❤️ المفضلة
    Route::post('/{slug}/favorite', [AdController::class, 'addFavorite'])->middleware('auth')->name('ads.favorite');
    Route::delete('/{slug}/unfavorite', [AdController::class, 'removeFavorite'])->middleware('auth')->name('ads.unfavorite');
    Route::post('/{slug}/toggle-favorite', [AdController::class, 'toggleFavorite'])->middleware('auth')->name('ads.toggleFavorite');

    # 🚨 بلاغ عن إعلان
    Route::post('/{slug}/report', [ReportController::class, 'store'])->middleware('auth')->name('ads.report');
});

# ------------------ 🚨 خدمات الطوارئ ------------------
Route::prefix('emergency-services')->group(function () {
    Route::get('/', [EmergencyServiceController::class, 'index'])->name('emergency_services.index');
    Route::get('/create', [EmergencyServiceController::class, 'create'])->name('emergency_services.create');
    Route::post('/', [EmergencyServiceController::class, 'store'])->name('emergency_services.store');
    Route::get('/map-data', [EmergencyServiceController::class, 'mapData'])->name('emergency_services.mapData');
    Route::get('/{id}', [EmergencyServiceController::class, 'show'])->name('emergency_services.show');
    Route::get('/{id}/edit', [EmergencyServiceController::class, 'edit'])->name('emergency_services.edit');
    Route::put('/{id}', [EmergencyServiceController::class, 'update'])->name('emergency_services.update');
    Route::delete('/{id}', [EmergencyServiceController::class, 'destroy'])->name('emergency_services.destroy');
});

Route::get('/emergency/statistics', [EmergencyStatisticsController::class, 'index'])->name('emergency.stats');
Route::get('/emergency', [EmergencyServiceController::class, 'index'])->name('emergency.index');

# بلاغات الطوارئ
    Route::middleware(['auth', 'blockBanned'])->prefix('emergency-reports')->group(function () {
    Route::get('/', [EmergencyReportController::class, 'index'])->name('emergency_reports.index');
    Route::get('/{id}', [EmergencyReportController::class, 'show'])->name('emergency_reports.show');
    Route::delete('/{id}', [EmergencyReportController::class, 'destroy'])->name('emergency_reports.destroy');
});
    Route::post('/emergency-reports', [EmergencyReportController::class, 'store'])->name('emergency_reports.store');

# =====================================================
# 🚖 Delni Taxi (النسخة الصحيحة)
# =====================================================

# الصفحة الرئيسية لخدمة التكسي
Route::get('/delni-taxi', [TaxiController::class, 'index'])->name('taxi.index');

# صفحة طلب التاكسي (النموذج الأولي)
Route::get('/taxi/request', [TaxiController::class, 'requestRide'])->name('taxi.request');

# إنشاء طلب تاكسي
Route::post('/taxi/order', [TaxiOrderController::class, 'store'])->name('taxi.order.store');

# حالة الطلب
Route::get('/taxi/order/{id}/status', [TaxiOrderController::class, 'showStatus'])->name('taxi.order.status');

# تحديث Realtime
Route::get('/taxi/order/{id}/realtime', [TaxiOrderController::class, 'updateRealtime'])->name('taxi.order.realtime');

# بدء الرحلة
Route::post('/taxi/order/{id}/start', [TaxiOrderController::class, 'startRide'])->name('taxi.order.start');

# إنهاء الرحلة
Route::post('/taxi/order/{id}/complete', [TaxiOrderController::class, 'complete'])->name('taxi.order.complete');

# إلغاء الطلب
Route::post('/taxi/order/{id}/cancel', [TaxiOrderController::class, 'cancel'])->name('taxi.order.cancel');

# دردشة الراكب
Route::get('/taxi/chat/{order_id}', [TaxiChatController::class, 'showPassengerChat'])->name('taxi.chat.passenger');

# دردشة السائق
Route::get('/driver/chat/{order_id}', [TaxiChatController::class, 'showDriverChat'])->name('taxi.chat.driver');

Route::post('/taxi/send-message', [TaxiChatController::class, 'sendMessage'])->name('taxi.message.send');

# رسائل AJAX
Route::get('/taxi/messages/{order_id}', [TaxiMessageController::class, 'index']);
Route::post('/taxi/messages', [TaxiMessageController::class, 'store']);
Route::post('/taxi/messages/fetch', [TaxiMessageController::class, 'fetch']);

# API السائق
Route::post('/api/taxi/driver/{id}/location', [DriverApiController::class, 'updateLocation']);
Route::get('/api/taxi/drivers', [DriverApiController::class, 'drivers']);

# ------------------ 👨‍✈️ تسجيل السائقين (للمشرف) ------------------
Route::prefix('drivers')->middleware(['auth'])->group(function () {
    Route::get('/', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('/create', [DriverController::class, 'create'])->name('drivers.create');
    Route::post('/store', [DriverController::class, 'store'])->name('drivers.store');
    Route::get('/{id}/edit', [DriverController::class, 'edit'])->name('drivers.edit');
    Route::put('/{id}', [DriverController::class, 'update'])->name('drivers.update');
    Route::post('/{id}/status', [DriverController::class, 'updateStatus'])->name('drivers.updateStatus');
    Route::delete('/{id}', [DriverController::class, 'destroy'])->name('drivers.destroy');
    Route::get('/{id}', [DriverController::class, 'show'])->name('drivers.show');
});


# =====================================================

# باقي المسارات (لوحة تحكم المستخدم / الدعم الفني / المشرف ... الخ) تبقى كما هي

# ------------------ 📊 لوحة تحكم المستخدم ------------------
    Route::middleware(['auth', 'blockBanned'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    # بياناتي
    Route::get('/myinfo', [DashboardController::class, 'myInfo'])->name('dashboard.myinfo');
    Route::get('/myinfo/edit', [DashboardController::class, 'editInfo'])->name('dashboard.myinfo.edit');
    Route::put('/myinfo/update', [DashboardController::class, 'updateInfo'])->name('dashboard.myinfo.update');

    # إعلاناتي
    Route::get('/myads', [DashboardController::class, 'myAds'])->name('dashboard.myads');
    Route::get('/ads/create', [AdController::class, 'create'])->name('dashboard.ads.create');
    Route::post('/ads', [AdController::class, 'store'])->name('dashboard.ads.store');
    Route::get('/ads/{id}/edit', [AdController::class, 'edit'])->name('dashboard.ads.edit');
    Route::put('/ads/{id}', [AdController::class, 'update'])->name('dashboard.ads.update');
    Route::delete('/ads/{id}', [AdController::class, 'destroy'])->name('dashboard.ads.destroy');
    // 🧑 عرض إعلانات مستخدم محدد
    Route::get('/user/{id}/ads', [App\Http\Controllers\UserController::class, 'ads'])->name('user.ads');

    # ⭐ التمييز
    Route::post('/ads/{id}/feature', [AdController::class, 'makeFeatured'])->name('dashboard.ads.feature');
    Route::post('/ads/{id}/unfeature', [AdController::class, 'removeFeatured'])->name('dashboard.ads.unfeature');

    # ❤️ المفضلة (فلترة + فرز + إزالة)
    Route::get('/favorites', [DashboardController::class, 'favorites'])->name('dashboard.favorites');

    # طلباتي
    Route::get('/myorders', [DashboardController::class, 'myOrders'])->name('dashboard.myorders');
    Route::get('/orders/{id}', [DashboardController::class, 'showOrder'])->name('dashboard.orders.show');

    # إحصائيات
    Route::get('/user-stats', [DashboardController::class, 'userStats'])->name('dashboard.userstats');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('dashboard.statistics');

    # كلمة المرور
    Route::get('/password/change', [DashboardController::class, 'editPassword'])->name('dashboard.password.change');
    Route::post('/password/update', [DashboardController::class, 'updatePassword'])->name('dashboard.password.update');

    # إشعارات
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('dashboard.notifications');
    Route::post('/notifications/mark-all-read', [DashboardController::class, 'markAllRead'])->name('dashboard.notifications.markAllRead');
    Route::post('/notifications/{id}/mark-read', [DashboardController::class, 'markRead'])->name('dashboard.notifications.markRead');
});

# ------------------ 🖼️ تفضيل عرض الإعلانات ------------------
Route::post('/dashboard/save-view', function (\Illuminate\Http\Request $request) {
    $user = auth()->user();
    $user->ads_view = $request->view;
    $user->save();
    return response()->json(['status' => 'ok']);
})->name('dashboard.saveView')->middleware('auth');

# ------------------ 🎫 تذاكر الدعم الفني (المستخدم) ------------------
    Route::middleware(['auth', 'blockBanned'])->prefix('support')->group(function () {
    Route::get('/', [SupportTicketController::class, 'index'])->name('support.index');
    Route::get('/create', [SupportTicketController::class, 'create'])->name('support.create');
    Route::post('/', [SupportTicketController::class, 'store'])->name('support.store');
    Route::get('/{id}', [SupportTicketController::class, 'show'])->name('support.show');
    Route::post('/{id}/reply', [SupportTicketController::class, 'reply'])->name('support.reply');
});

# ------------------ 🛠️ لوحة تحكم المشرف ------------------
    Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{id}/promote', [App\Http\Controllers\Admin\UserController::class, 'promote'])->name('admin.users.promote');
    Route::post('/users/{id}/toggle-ban', [App\Http\Controllers\Admin\UserController::class, 'toggleBan'])
    ->name('admin.users.toggleBan');
    Route::get('/visitors', [App\Http\Controllers\Admin\VisitorController::class, 'index'])->name('admin.visitors.index');

    # 🎯 إدارة البانرات
    Route::resource('banners', \App\Http\Controllers\BannerController::class);

# 🖼️ إدارة بانرات المول
Route::resource('mall-banners', \App\Http\Controllers\MallBannerController::class);

# إدارة بانرات الخدمات
Route::resource('service-banners', App\Http\Controllers\ServiceBannerController::class);

    # 🔔 إشعارات المشرف
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::post('/notifications/mark-all-read', [AdminController::class, 'markAllAsRead'])->name('admin.notifications.markAllAsRead');
    Route::post('/notifications/{id}/mark-read', [AdminController::class, 'markAsRead'])->name('admin.notifications.markAsRead');

    # 📊 إحصائيات الموقع
    Route::get('/statistics', [\App\Http\Controllers\Dashboard\StatisticsController::class, 'index'])
        ->name('admin.statistics');

    Route::get('/taxi-orders', [TaxiOrderController::class, 'index'])->name('admin.taxi.orders');

    # 🔔 إشعارات المشرف
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');

    # 🎫 دعم فني
    Route::get('/support-tickets', [SupportTicketAdminController::class, 'index'])->name('admin.support_tickets.index');
    Route::get('/support-tickets/statistics', [SupportTicketAdminController::class, 'statistics'])->name('admin.support_tickets.statistics');
    Route::get('/support-tickets/{id}', [SupportTicketAdminController::class, 'show'])->name('admin.support_tickets.show');
    Route::put('/support-tickets/{id}', [SupportTicketAdminController::class, 'update'])->name('admin.support_tickets.update');

    # 🚨 الطوارئ
    Route::get('/emergency-dashboard', [EmergencyReportController::class, 'dashboard'])->name('admin.emergency_dashboard');
    Route::get('/emergency-reports', [AdminEmergencyReportController::class, 'index'])->name('admin.emergency_reports.index');
    Route::get('/emergency-reports/{id}', [AdminEmergencyReportController::class, 'show'])->name('admin.emergency_reports.show');
    Route::post('/emergency-reports/{id}/update-status', [AdminEmergencyReportController::class, 'updateStatus'])->name('admin.emergency_reports.update_status');
    Route::delete('/emergency-reports/{id}', [AdminEmergencyReportController::class, 'destroy'])->name('admin.emergency_reports.destroy');

    # 🟡 تعديل هنا: بدل ما نعمل نسخة جديدة لمسار emergency-services
    Route::get('/emergency-services', function () {
        return redirect()->route('emergency_services.index');
    })->name('admin.emergency_services.index');

    Route::get('/emergency-centers', [AdminEmergencyController::class, 'index'])->name('admin.emergency_centers.index');
    Route::get('/emergency/statistics', [EmergencyStatisticsController::class, 'index'])->name('admin.emergency.stats');
});

# ------------------ ⚠️ صفحات اختبار الأخطاء ------------------
foreach ([401,403,404,419,422,429,500,503] as $code) {
    Route::get("/test-error-$code", fn() => abort($code));
}

# ------------------ 📂 إعلانات متخصصة ------------------
// 🏠 عقارات
Route::get('/ads/realestate', [AdController::class, 'realestate'])->name('ads.realestate');

// 🚗 سيارات
Route::get('/ads/cars', [AdController::class, 'cars'])->name('ads.cars');

// 🛠️ خدمات
Route::get('/ads/services', [AdController::class, 'services'])->name('ads.services');

// صفحة قائمة الخدمات الرئيسية
Route::get('/services', [\App\Http\Controllers\ServicesController::class, 'index'])
    ->name('services.index');

// عرض الخدمات حسب النوع
Route::get('/services/type/{service_type}', [\App\Http\Controllers\ServiceController::class, 'byType'])
    ->name('services.byType');

// صفحة تفاصيل الخدمة
Route::get('/services/{subcategory}', [\App\Http\Controllers\ServicesController::class, 'show'])
    ->name('services.show');

// حفظ التقييم (يتطلب تسجيل دخول)
Route::post('/services/rate', [\App\Http\Controllers\ServiceRatingController::class, 'store'])
    ->middleware('auth')
    ->name('service.rating.store');

Route::post('/services/rating/update', [\App\Http\Controllers\ServiceRatingController::class, 'update'])
    ->name('service.rating.update');

Route::get('/login-phone', [WhatsappAuthController::class, 'loginPage'])->name('login.phone');
Route::post('/send-code', [WhatsappAuthController::class, 'sendCode'])->name('send.code');
Route::get('/verify-code', [WhatsappAuthController::class, 'verifyPage'])->name('verify.code.page');
Route::post('/verify-code', [WhatsappAuthController::class, 'verifyCode'])->name('verify.code');

// تسجيل خروج
Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/banned', function() {
    return view('auth.banned');
})->name('banned.message');
