<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\{
    AdController,
    AdminController,
    AdminEmergencyController,
    ContactController,
    Dashboard\StatisticsController,
    DashboardController,
    DriverController,
    EmergencyReportController,
    EmergencyServiceController,
    EmergencyStatisticsController,
    FavoriteController,
    HomeController,
    MapController,
    MessageController,
    OrderController,
    ProfileController,
    RatingController,
    ReportController,
    SupportTicketController,
    TaxiChatController,
    TaxiController,
    TaxiDriversMapController,
    TaxiFareController,
    TaxiMapController,
    TaxiMessageController,
    TaxiOrderController,
    UserController
};

use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboard,
    EmergencyReportController as AdminEmergencyReportController,
    SupportTicketAdminController
};

/* ========================
   اللغات
======================== */
Route::get('/lang/{locale}', function (Request $request, string $locale) {
    $allowed = ['ar', 'en'];
    abort_if(! in_array($locale, $allowed, true), 404);

    $request->session()->put('locale', $locale);
    app()->setLocale($locale);

    $prev = url()->previous() ?: route('home');
    if (! str_starts_with($prev, url('/'))) $prev = route('home');

    return redirect()->to($prev);
})->name('change.lang');

Route::get('/lang-switch/{locale}', fn (string $locale) => redirect()->route('change.lang', ['locale' => $locale]))->name('lang.switch');
Route::get('/change-language/{lang}', fn (string $lang) => redirect()->route('change.lang', ['locale' => $lang]))->name('change-language');

/* ========================
   مصادقة
======================== */
require __DIR__.'/auth.php';

/* السماح بالـ GET على /logout (توافق) */
Route::get('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy']);
/* صفحة “تم تسجيل الخروج” */
Route::view('/logged-out', 'auth.logged-out')->name('auth.logged-out');

/* منع زيارة /api/login|register بالخطأ من المتصفح */
Route::get('/api/login', fn () => redirect()->route('login'));
Route::get('/api/register', fn () => redirect()->route('register'));

/* ========================
   كل الواجهات تمر عبر setlocale
======================== */
Route::middleware('setlocale')->group(function () {

    /* ========================
       صفحات عامة
    ======================== */
    Route::get('/', [AdController::class, 'index'])->name('home');
    Route::view('/about', 'pages.about')->name('about');
    Route::view('/privacy', 'pages.privacy')->name('privacy');
    Route::view('/terms', 'pages.terms')->name('terms');
    Route::view('/faq', 'pages.faq')->name('faq');

    Route::get('/contact', [ContactController::class, 'show'])->name('contact');
    Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

    /* ========================
       لوحة المستخدم (Dashboard)
    ======================== */
    Route::put('/dashboard/update-password', [DashboardController::class, 'updatePassword'])->name('dashboard.updatepassword');

    Route::middleware(['auth'])->prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

        // الحساب وكلمة المرور
        Route::get('/edit-password', [DashboardController::class, 'editPassword'])->name('dashboard.editpassword');
        Route::get('/password/change', [DashboardController::class, 'changePassword'])->name('dashboard.password.change');
        Route::post('/password/update', [DashboardController::class, 'updatePassword'])->name('dashboard.password.update');

        // بياناتي
        Route::get('/myinfo', [DashboardController::class, 'myInfo'])->name('dashboard.myinfo');
        Route::get('/myinfo/edit', [DashboardController::class, 'editInfo'])->name('dashboard.myinfo.edit');
        Route::post('/myinfo/update', [DashboardController::class, 'updateInfo'])->name('dashboard.myinfo.update');

        // إعلاناتي
        Route::get('/myads', [DashboardController::class, 'myAds'])->name('dashboard.myads');

        // CRUD إعلانات من داخل الداشبورد
        Route::get('/ads/create', [AdController::class, 'create'])->name('dashboard.ads.create');
        Route::post('/ads/store', [AdController::class, 'store'])->name('dashboard.ads.store');
        Route::get('/ads/{id}/edit', [AdController::class, 'edit'])->name('dashboard.ads.edit');
        Route::post('/ads/{id}', [AdController::class, 'update'])->name('dashboard.ads.update');
        Route::delete('/ads/{id}', [AdController::class, 'destroy'])->name('dashboard.ads.destroy');

        // تمييز/إلغاء تمييز إعلان
        Route::post('/ads/{id}/feature', [AdController::class, 'feature'])->name('ads.feature');
        Route::post('/ads/{id}/unfeature', [AdController::class, 'unfeature'])->name('ads.unfeature');

        // المفضلة — إبقاء الاسمين للتوافق
        Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::get('/favorites', [FavoriteController::class, 'index'])->name('dashboard.favorites');
        Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

        // الدعم
        Route::get('/support', [SupportTicketController::class, 'index'])->name('support.index');
        Route::get('/support/create', [SupportTicketController::class, 'create'])->name('support.create');
        Route::post('/support', [SupportTicketController::class, 'store'])->name('support.store');
        Route::get('/support/{id}', [SupportTicketController::class, 'show'])->name('support.show');
    });

    /* ========================
       الإعلانات (عام)
    ======================== */
    Route::prefix('ads')->group(function () {
        Route::get('/', [AdController::class, 'index'])->name('ads.index');
        Route::get('/{id}', [AdController::class, 'show'])->name('ads.show');
        Route::get('/featured', [AdController::class, 'featured'])->name('ads.featured');

        // مفضلة عبر صفحة الإعلان
        Route::post('/{id}/favorite', [AdController::class, 'addFavorite'])->name('ads.favorite');
        Route::delete('/{id}/unfavorite', [AdController::class, 'removeFavorite'])->name('ads.unfavorite');

        // بلاغ على إعلان
        Route::post('/{id}/report', [ReportController::class, 'store'])->middleware('auth')->name('ads.report');

        // حفظ مفضلة (توافق قديم)
        Route::post('/favorites/{ad}', [FavoriteController::class, 'store'])->name('favorites.store');
    });

    /* ========================
       خدمات الطوارئ (مستخدم)
    ======================== */
    Route::prefix('emergency-services')->group(function () {
        Route::get('/',         [EmergencyServiceController::class, 'index'])->name('emergency_services.index');
        Route::get('/create',   [EmergencyServiceController::class, 'create'])->name('emergency_services.create');
        Route::post('/',        [EmergencyServiceController::class, 'store'])->name('emergency_services.store');
        Route::get('/{id}',     [EmergencyServiceController::class, 'show'])->name('emergency_services.show');
        Route::get('/{id}/edit',[EmergencyServiceController::class, 'edit'])->name('emergency_services.edit');
        Route::put('/{id}',     [EmergencyServiceController::class, 'update'])->name('emergency_services.update');
        Route::delete('/{id}',  [EmergencyServiceController::class, 'destroy'])->name('emergency_services.destroy');

        // بيانات الخريطة
        Route::get('/map-data', [EmergencyServiceController::class, 'mapData'])->name('emergency_services.mapData');
    });

    // توافق قديم للمسارات
    Route::get('/emergency', fn () => redirect()->route('emergency_services.index', request()->query()))->name('emergency.index');
    Route::post('/emergency-services', [EmergencyServiceController::class, 'store'])->name('emergency.store'); // POST alias
    Route::get('/emergency/statistics', [EmergencyStatisticsController::class, 'index'])->name('emergency.stats');

    /* ========================
       تقارير الطوارئ
    ======================== */
    // عرض وإدارة (للمستخدمين المسجلين)
    Route::middleware(['auth'])->prefix('emergency-reports')->group(function () {
        Route::get('/',       [EmergencyReportController::class, 'index'])->name('emergency_reports.index');
        Route::get('/{id}',   [EmergencyReportController::class, 'show'])->name('emergency_reports.show');
        Route::delete('/{id}',[EmergencyReportController::class, 'destroy'])->name('emergency_reports.destroy');
    });
    // إنشاء بلاغ (مفتوح من المودال)
    Route::post('/emergency-reports', [EmergencyReportController::class, 'store'])->name('emergency_reports.store');

    /* ========================
       Delni Taxi
    ======================== */
    Route::get('/delni-taxi-en', fn () => view('taxi.landing-en'))->name('taxi.english');
    Route::view('/taxi-info', 'taxi.landing')->name('taxi.info');

    Route::get('/delni-taxi', [TaxiController::class, 'index'])->name('delni.taxi');
    Route::get('/taxi',        [TaxiController::class, 'landing'])->name('taxi.landing');

    Route::post('/taxi/calculate-fare', [TaxiFareController::class, 'calculate'])->name('taxi.calculateFare');

    Route::post('/taxi/request', [OrderController::class, 'store'])->name('taxi.request');
    Route::get('/order-status', [OrderController::class, 'status'])->name('order.status');
    Route::get('/trip/completed', [TaxiController::class, 'tripCompleted'])->name('trip.completed');

    Route::post('/submit-rating', [RatingController::class, 'store'])->name('submit.rating');
    Route::post('/taxi/order/complete-with-rating', [TaxiOrderController::class, 'completeWithRating'])->name('taxi.complete.with.rating');

    Route::get('/taxi/order/{id}/status', [TaxiOrderController::class, 'showStatus'])->name('taxi.order.status');
    Route::post('/taxi/order/save-from-map', [TaxiOrderController::class, 'storeFromMap'])->name('taxi.order.saveFromMap');

    /* خريطة طلب عامة */
    Route::get('/taxi/order-map', function () {
        $request = request();
        $startStr = $request->query('start', '36.2021,37.1343');
        $endStr   = $request->query('end',   '36.2155,37.1590');
        [$sLat, $sLng] = array_map('floatval', explode(',', $startStr));
        [$eLat, $eLng] = array_map('floatval', explode(',', $endStr));
        $start = ['lat' => $sLat, 'lng' => $sLng, 'label' => $request->query('start_label', 'نقطة الانطلاق')];
        $end   = ['lat' => $eLat, 'lng' => $eLng, 'label' => $request->query('end_label', 'نقطة الوصول')];
        return view('taxi.order-map', compact('start', 'end'));
    })->name('taxi.order.map');

    // Alias لتوافق قديم: route('taxi.map')
    Route::get('/taxi/map', fn () => redirect()->route('taxi.order.map'))->name('taxi.map');

    /* واجهة عامة لطلبات التاكسي لتفادي "GET not supported" */
    Route::get('/taxi-orders/create', [TaxiOrderController::class, 'create'])->name('taxi.orders.create.public');
    Route::get('/taxi-orders', fn () => redirect()->route('taxi.orders.create.public'));
    Route::post('/taxi-orders', [TaxiOrderController::class, 'store'])->name('taxi.orders.store.public');

    Route::get('/taxi/order/{id}/json', function ($id) {
        $order  = \App\Models\TaxiOrder::findOrFail($id);
        $driver = \App\Models\Driver::find($order->driver_id);
        return response()->json([
            'order'  => $order,
            'driver' => $driver ? $driver->only(['id','name','phone','status','latitude','longitude']) : null,
        ]);
    })->name('taxi.order.json');

    Route::post('/driver/update-location', [DriverController::class, 'updateLocation'])->name('driver.update.location');

    /* دردشة التاكسي */
    Route::post('/driver/message', [TaxiMessageController::class, 'store'])->name('driver.message.store');
    Route::get('/driver/messages', [TaxiMessageController::class, 'fetch'])->name('driver.message.fetch');
    Route::get('/chat/{order}', [TaxiMessageController::class, 'driverChat'])->name('driver.chat');
    Route::post('/chat/{order}', [TaxiMessageController::class, 'driverReply'])->name('driver.message.reply');
    Route::get('/taxi/chat/{order_id}', [TaxiChatController::class, 'showPassengerChat'])->name('passenger.chat');

    /* تسجيل السائقين + لوحة السائق */
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
    Route::get('/drivers/map', [TaxiMapController::class, 'index'])->name('drivers.map');

    /* شاشة تسجيل السائق (عام) */
    Route::get('/driver/register', [DriverController::class, 'showRegisterForm'])->name('driver.register');
    Route::post('/driver/register', [DriverController::class, 'register'])->name('driver.register.submit');

    /* لوحة السائق (محمية) */
    Route::middleware(['auth', 'driver'])->group(function () {
        Route::get('/driver/dashboard', [DriverController::class, 'dashboard'])->name('driver.dashboard');
    });

    /* ========================
       لوحة الإدارة
    ======================== */
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminDashboard::class, 'index'])->name('admin.dashboard');
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('dashboard.statistics');

        // طلبات التاكسي
        Route::get('/taxi-orders', [TaxiOrderController::class, 'index'])->name('admin.taxi.orders');
        Route::get('/taxi-orders/create', [TaxiOrderController::class, 'create'])->name('taxi.orders.create');
        Route::post('/taxi-orders', [TaxiOrderController::class, 'store'])->name('taxi.orders.store');
        Route::get('/taxi/track/{orderId}', fn ($orderId) => view('taxi.track', ['orderId' => $orderId]))->name('taxi.track');

        // إشعارات/دعم
        Route::get('/dashboard/favorites', fn () => view('dashboard.favorites'))->name('dashboard.favorites.admin');
        Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');

        Route::get('/support-tickets', [SupportTicketAdminController::class, 'index'])->name('admin.support_tickets.index');
        Route::get('/support-tickets/statistics', [SupportTicketAdminController::class, 'statistics'])->name('admin.support_tickets.statistics');
        Route::get('/support-tickets/{id}', [SupportTicketAdminController::class, 'show'])->name('admin.support_tickets.show');
        Route::put('/support-tickets/{id}', [SupportTicketAdminController::class, 'update'])->name('admin.support_tickets.update');

        // تقارير الطوارئ
        Route::get('/emergency-dashboard', [EmergencyReportController::class, 'dashboard'])->name('admin.emergency_dashboard');
        Route::get('/emergency-reports', [AdminEmergencyReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/emergency-reports/{id}', [AdminEmergencyReportController::class, 'show'])->name('admin.emergency_reports.show');
        Route::post('/emergency-reports/{id}/update-status', [AdminEmergencyReportController::class, 'updateStatus'])->name('admin.emergency_reports.update_status');
        Route::delete('/emergency-reports/{id}', [AdminEmergencyReportController::class, 'destroy'])->name('admin.emergency_reports.destroy');

        // عرض مراكز الطوارئ والإحصائيات
        Route::get('/emergency-services', [EmergencyServiceController::class, 'index'])->name('admin.emergency_services.index');
        Route::get('/emergency-centers', [AdminEmergencyController::class, 'index'])->name('admin.emergency_centers.index');
        Route::get('/emergency/statistics', [EmergencyStatisticsController::class, 'index'])->name('admin.emergency.stats');
    });

    /* --- صفحات بسيطة مسماة --- */
    Route::view('/services', 'services.index')->name('services.index');
    // ⚠️ لا ننشئ Route::view('/emergency-services', ...) حتى لا نصطدم مع مجموعة الكنترولر أعلاه.

    /* ========================
       Fallback
    ======================== */
    Route::fallback(function () {
        return view('errors.404');
    });
});
