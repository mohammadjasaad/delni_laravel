<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdController, ContactController, DashboardController,
    EmergencyServiceController, EmergencyReportController,
    DriverController, TaxiDriverController, TaxiController,
    TaxiOrderController, TaxiMessageController, TaxiChatController,
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

# ------------------ 🏠 الصفحة الرئيسية ------------------
Route::get('/', [AdController::class, 'index'])->name('home');

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

Route::prefix('ads')->group(function () {
    Route::get('/', [AdController::class, 'index'])->name('ads.index');
    Route::get('/create', [AdController::class, 'create'])->middleware('auth')->name('ads.create');
    Route::post('/', [AdController::class, 'store'])->middleware('auth')->name('ads.store');

    # 🗺️ بيانات الإعلانات للخريطة (لازم قبل {id})
    Route::get('/map-data', [AdController::class, 'mapData'])->name('ads.mapData');

    # 👁️ عرض إعلان
    Route::get('/{id}', [AdController::class, 'show'])->name('ads.show');

    # ❤️ المفضلة
    Route::post('/{id}/favorite', [AdController::class, 'addFavorite'])->middleware('auth')->name('ads.favorite');
    Route::delete('/{id}/unfavorite', [AdController::class, 'removeFavorite'])->middleware('auth')->name('ads.unfavorite');

    # 🚨 بلاغ عن إعلان
    Route::post('/{id}/report', [ReportController::class, 'store'])->middleware('auth')->name('ads.report');
});

# ------------------ 🚨 خدمات الطوارئ ------------------
Route::prefix('emergency-services')->group(function () {
    Route::get('/', [EmergencyServiceController::class, 'index'])->name('emergency_services.index');
    Route::get('/create', [EmergencyServiceController::class, 'create'])->name('emergency_services.create');
    Route::post('/', [EmergencyServiceController::class, 'store'])->name('emergency_services.store');
    Route::get('/map-data', [EmergencyServiceController::class, 'mapData'])->name('emergency_services.mapData');

    # 👁️ عرض مركز
    Route::get('/{id}', [EmergencyServiceController::class, 'show'])->name('emergency_services.show');

    # ✏️ تعديل مركز
    Route::get('/{id}/edit', [EmergencyServiceController::class, 'edit'])->name('emergency_services.edit');
    Route::put('/{id}', [EmergencyServiceController::class, 'update'])->name('emergency_services.update');

    # 🗑️ حذف مركز
    Route::delete('/{id}', [EmergencyServiceController::class, 'destroy'])->name('emergency_services.destroy');
});

Route::get('/emergency/statistics', [EmergencyStatisticsController::class, 'index'])->name('emergency.stats');

# بلاغات الطوارئ (للمستخدم)
Route::middleware(['auth'])->prefix('emergency-reports')->group(function () {
    Route::get('/', [EmergencyReportController::class, 'index'])->name('emergency_reports.index');
    Route::get('/{id}', [EmergencyReportController::class, 'show'])->name('emergency_reports.show');
    Route::delete('/{id}', [EmergencyReportController::class, 'destroy'])->name('emergency_reports.destroy');
});
Route::post('/emergency-reports', [EmergencyReportController::class, 'store'])->name('emergency_reports.store');

# ------------------ 🚖 خدمات Delni Taxi ------------------
Route::get('/delni-taxi', [TaxiController::class, 'index'])->name('delni.taxi');
Route::post('/taxi/request', [OrderController::class, 'store'])->name('taxi.request');
Route::get('/order-status', [OrderController::class, 'status'])->name('order.status');
Route::get('/trip/completed', [TaxiController::class, 'tripCompleted'])->name('trip.completed');
Route::post('/submit-rating', [RatingController::class, 'store'])->name('submit.rating');
Route::post('/taxi/order/complete-with-rating', [TaxiOrderController::class, 'completeWithRating'])->name('taxi.complete.with.rating');
Route::get('/taxi/order/{id}/status', [TaxiOrderController::class, 'showStatus'])->name('taxi.order.status');

# صفحات ثابتة للتكسي
Route::view('/order-taxi', 'order-taxi')->name('order.taxi');
Route::view('/driver/login', 'taxi.drivers.login')->name('driver.login');
Route::view('/driver/dashboard', 'taxi.drivers.panel')->name('driver.dashboard');
Route::view('/services', 'services.index')->name('services');

# دردشة التاكسي
Route::post('/driver/message', [TaxiMessageController::class, 'store'])->name('driver.message.store');
Route::get('/driver/messages', [TaxiMessageController::class, 'fetch'])->name('driver.message.fetch');
Route::get('/chat/{order}', [TaxiMessageController::class, 'driverChat'])->name('driver.chat');
Route::post('/chat/{order}', [TaxiMessageController::class, 'driverReply'])->name('driver.message.reply');
Route::get('/taxi/chat/{order_id}', [TaxiChatController::class, 'showPassengerChat'])->name('passenger.chat');

# API داخل الويب
Route::get('/api/driver-location/{id}', [TaxiController::class, 'driverLocation'])->name('api.driver.location');
Route::get('/api/drivers', fn () => \App\Models\TaxiDriver::all())->name('api.drivers');

# ------------------ 👨‍✈️ تسجيل السائقين ------------------
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
Route::get('/drivers/map', [TaxiDriverController::class, 'index'])->name('drivers.map');

# ------------------ 📊 لوحة تحكم المستخدم ------------------
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    # بياناتي
    Route::get('/myinfo', [DashboardController::class, 'myInfo'])->name('dashboard.myinfo');
    Route::get('/myinfo/edit', [DashboardController::class, 'editInfo'])->name('dashboard.myinfo.edit');
    Route::post('/myinfo/update', [DashboardController::class, 'updateInfo'])->name('dashboard.myinfo.update');

    # إعلاناتي
    Route::get('/myads', [DashboardController::class, 'myAds'])->name('dashboard.myads');
    Route::get('/ads/create', [AdController::class, 'create'])->name('dashboard.ads.create');
    Route::post('/ads', [AdController::class, 'store'])->name('dashboard.ads.store');
    Route::get('/ads/{id}/edit', [AdController::class, 'edit'])->name('dashboard.ads.edit');
    Route::put('/ads/{id}', [AdController::class, 'update'])->name('dashboard.ads.update');
    Route::delete('/ads/{id}', [AdController::class, 'destroy'])->name('dashboard.ads.destroy');

    # ⭐ التمييز
    Route::post('/ads/{id}/feature', [AdController::class, 'makeFeatured'])->name('dashboard.ads.feature');
    Route::post('/ads/{id}/unfeature', [AdController::class, 'removeFeatured'])->name('dashboard.ads.unfeature');

    # ❤️ المفضلة (فلترة + فرز + إزالة)
    Route::get('/favorites', [DashboardController::class, 'favorites'])->name('dashboard.favorites');

    # طلباتي
    Route::get('/myorders', [DashboardController::class, 'myOrders'])->name('dashboard.myorders');

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
Route::middleware(['auth'])->prefix('support')->group(function () {
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
    Route::get('/visitors', [App\Http\Controllers\Admin\VisitorController::class, 'index'])->name('admin.visitors.index');

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
