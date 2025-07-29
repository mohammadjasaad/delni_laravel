<?php

use App\Http\Controllers\EmergencyStatisticsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController, ContactController, MessageController,
    AdController, ReportController, FavoriteController,
    DashboardController, ProfileController,
    EmergencyServiceController, EmergencyReportController,
    DriverController, TaxiDriverController,
    OrderController, RatingController, TaxiController,
    TaxiMapController, TaxiMessageController, TaxiChatController,
    MapController, UserController, AdminController,
    Dashboard\StatisticsController,
    Admin\DashboardController as AdminDashboard,
    Admin\EmergencyReportController as AdminEmergencyReportController,
    AdminEmergencyController,
    SupportTicketController,
    TaxiOrderController,
    Admin\SupportTicketAdminController
};

// ✅ صفحات عامة
Route::get('/', [AdController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/faq', 'pages.faq')->name('faq');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// ✅ تسجيل الدخول والتسجيل
require __DIR__.'/auth.php';

// ✅ إعدادات الحساب
Route::put('/dashboard/update-password', [DashboardController::class, 'updatePassword'])->name('dashboard.updatepassword');

// ✅ إعدادات الحساب - تعديل كلمة المرور للمستخدم
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/edit-password', [DashboardController::class, 'editPassword'])->name('dashboard.editpassword');
    Route::put('/update-password', [DashboardController::class, 'updatePassword'])->name('dashboard.updatepassword');
});

// ✅ تعدد اللغات
Route::get('/lang/{locale}', fn($locale) => in_array($locale, ['ar', 'en']) ? session(['locale' => $locale]) : null)->name('lang.switch');
Route::get('change-language/{lang}', fn($lang) => session()->put('locale', $lang))->name('change-language');

// ✅ الإعلانات
Route::prefix('ads')->group(function () {
    Route::get('/', [AdController::class, 'index'])->name('ads.index');
    Route::get('/{id}', [AdController::class, 'show'])->name('ads.show');
    Route::post('/{id}/favorite', [AdController::class, 'addFavorite'])->name('ads.favorite');
    Route::delete('/{id}/unfavorite', [AdController::class, 'removeFavorite'])->name('ads.unfavorite');
    Route::post('/{id}/report', [ReportController::class, 'store'])->middleware('auth')->name('ads.report');
    Route::get('/featured', [AdController::class, 'featured'])->name('ads.featured');
// ✅ حفظ الإعلان كمفضل
Route::post('/favorites/{ad}', [\App\Http\Controllers\FavoriteController::class, 'store'])->name('favorites.store');

});

// ✅ خدمات الطوارئ
Route::prefix('emergency-services')->group(function () {
    Route::get('/', [EmergencyServiceController::class, 'index'])->name('emergency.index');
    Route::get('/create', [EmergencyServiceController::class, 'create'])->name('emergency_services.create');
    Route::post('/', [EmergencyServiceController::class, 'store'])->name('emergency_services.store');
    Route::get('/{id}', [EmergencyServiceController::class, 'show'])->name('emergency_services.show');
    Route::get('/map-data', [EmergencyServiceController::class, 'mapData'])->name('emergency_services.mapData');
});

Route::get('/emergency/statistics', [EmergencyStatisticsController::class, 'index'])->name('emergency.stats');

// ✅ بلاغات الطوارئ للمستخدم
Route::middleware(['auth'])->prefix('emergency-reports')->group(function () {
    Route::get('/', [EmergencyReportController::class, 'index'])->name('emergency_reports.index');
    Route::get('/{id}', [EmergencyReportController::class, 'show'])->name('emergency_reports.show');
    Route::delete('/{id}', [EmergencyReportController::class, 'destroy'])->name('emergency_reports.destroy');
});

Route::post('/emergency-reports', [EmergencyReportController::class, 'store'])->name('emergency_reports.store');

// ✅ خدمات Delni Taxi
Route::get('/delni-taxi', [TaxiController::class, 'index'])->name('delni.taxi');
Route::post('/taxi/request', [OrderController::class, 'store'])->name('taxi.request');
Route::get('/order-status', [OrderController::class, 'status'])->name('order.status');
Route::get('/trip/completed', [TaxiController::class, 'tripCompleted'])->name('trip.completed');
Route::post('/submit-rating', [RatingController::class, 'store'])->name('submit.rating');
Route::post('/taxi/order/complete-with-rating', [TaxiOrderController::class, 'completeWithRating'])->name('taxi.complete.with.rating');
Route::get('/taxi/order/{id}/status', [TaxiOrderController::class, 'showStatus'])->name('taxi.order.status');

Route::view('/order-taxi', 'order-taxi')->name('order.taxi');
Route::view('/driver/login', 'taxi.drivers.login')->name('driver.login');
Route::view('/driver/dashboard', 'taxi.drivers.panel')->name('driver.dashboard');
Route::view('/services', 'services.index')->name('services');

// ✅ دردشة التاكسي
Route::post('/driver/message', [TaxiMessageController::class, 'store'])->name('driver.message.store');
Route::get('/driver/messages', [TaxiMessageController::class, 'fetch'])->name('driver.message.fetch');
Route::get('/chat/{order}', [TaxiMessageController::class, 'driverChat'])->name('driver.chat');
Route::post('/chat/{order}', [TaxiMessageController::class, 'driverReply'])->name('driver.message.reply');
Route::get('/taxi/chat/{order_id}', [TaxiChatController::class, 'showPassengerChat'])->name('passenger.chat');

// ✅ API
Route::get('/api/driver-location/{id}', [TaxiController::class, 'driverLocation'])->name('api.driver.location');
Route::get('/api/drivers', fn () => \App\Models\TaxiDriver::all())->name('api.drivers');

// ✅ تسجيل السائقين
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

// ✅ لوحة تحكم المستخدم
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/myinfo', [DashboardController::class, 'myInfo'])->name('dashboard.myinfo');
    Route::get('/myinfo/edit', [DashboardController::class, 'editInfo'])->name('dashboard.myinfo.edit');
    Route::post('/myinfo/update', [DashboardController::class, 'updateInfo'])->name('dashboard.myinfo.update');

    Route::get('/myads', [AdController::class, 'myAds'])->name('dashboard.myads');
    Route::get('/ads/create', [AdController::class, 'create'])->name('dashboard.ads.create');
    Route::post('/ads/store', [AdController::class, 'store'])->name('dashboard.ads.store');
    Route::get('/ads/{id}/edit', [AdController::class, 'edit'])->name('dashboard.ads.edit');
    Route::post('/ads/{id}', [AdController::class, 'update'])->name('dashboard.ads.update');
    Route::delete('/ads/{id}', [AdController::class, 'destroy'])->name('dashboard.ads.destroy');
    Route::post('/ads/{id}/feature', [AdController::class, 'feature'])->name('ads.feature');
    Route::post('/ads/{id}/unfeature', [AdController::class, 'unfeature'])->name('ads.unfeature');

    Route::get('/account/settings', [DashboardController::class, 'accountSettings'])->name('dashboard.settings');
    Route::post('/account/settings/update', [DashboardController::class, 'updateAccountSettings'])->name('dashboard.settings.update');
    Route::get('/password/change', [DashboardController::class, 'changePassword'])->name('dashboard.password.change');
    Route::post('/password/update', [DashboardController::class, 'updatePassword'])->name('dashboard.password.update');

    Route::get('/myorders', [DashboardController::class, 'myOrders'])->name('dashboard.myorders');

    Route::get('/support', [SupportTicketController::class, 'index'])->name('support.index');
    Route::get('/support/create', [SupportTicketController::class, 'create'])->name('support.create');
    Route::post('/support', [SupportTicketController::class, 'store'])->name('support.store');
    Route::get('/support/{id}', [SupportTicketController::class, 'show'])->name('support.show');
// ✅ المفضلة
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

});

// ✅ لوحة تحكم المشرف
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('dashboard.statistics');
    Route::get('/taxi-orders', [TaxiOrderController::class, 'index'])->name('admin.taxi.orders');
    Route::get('/dashboard/favorites', fn () => view('dashboard.favorites'))->name('dashboard.favorites');

    Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');

    Route::get('/support-tickets', [SupportTicketAdminController::class, 'index'])->name('admin.support_tickets.index');
    Route::get('/support-tickets/statistics', [SupportTicketAdminController::class, 'statistics'])->name('admin.support_tickets.statistics');
    Route::get('/support-tickets/{id}', [SupportTicketAdminController::class, 'show'])->name('admin.support_tickets.show');
    Route::put('/support-tickets/{id}', [SupportTicketAdminController::class, 'update'])->name('admin.support_tickets.update');

    Route::get('/emergency-dashboard', [EmergencyReportController::class, 'dashboard'])->name('admin.emergency_dashboard');
    Route::get('/emergency-reports', [AdminEmergencyReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/emergency-reports/{id}', [AdminEmergencyReportController::class, 'show'])->name('admin.emergency_reports.show');
    Route::post('/emergency-reports/{id}/update-status', [AdminEmergencyReportController::class, 'updateStatus'])->name('admin.emergency_reports.update_status');
    Route::delete('/emergency-reports/{id}', [AdminEmergencyReportController::class, 'destroy'])->name('admin.emergency_reports.destroy');
    Route::get('/emergency-services', [EmergencyServiceController::class, 'index'])->name('emergency_services.index');
    Route::get('/emergency-centers', [AdminEmergencyController::class, 'index'])->name('admin.emergency_centers.index');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{id}/promote', [UserController::class, 'promote'])->name('admin.users.promote');
Route::get('/emergency/statistics', [EmergencyStatisticsController::class, 'index'])->name('emergency.stats');

});
