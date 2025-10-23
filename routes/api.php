<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BannerApiController;
use App\Http\Controllers\Api\MallBannerApiController;

// ✅ تسجيل الدخول والتسجيل API
Route::post('/login',    [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);

// ✅ مستخدم عام (اختبار)
Route::get('/user', fn() => response()->json(['message' => 'Public user endpoint']));

// ✅ الإعلانات API
Route::get('/ads/search', [AdApiController::class, 'search']); // 👈 هذا يجب أن يكون أولاً
Route::get('/ads', [AdApiController::class, 'index']);
Route::get('/ads/{id}', [AdApiController::class, 'show']);
Route::post('/ads', [AdApiController::class, 'store'])->middleware('auth:sanctum');
Route::put('/ads/{id}', [AdApiController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/ads/{id}', [AdApiController::class, 'destroy'])->middleware('auth:sanctum');
Route::put('/ads/{id}/merge', [AdApiController::class, 'updateMerge'])->middleware('auth:sanctum');

// ✅ إعلاناتي عبر API
Route::get('/my-ads', [AdApiController::class, 'myAds'])->middleware('auth:sanctum'); // ✅ تصحيح هنا

Route::get('/banners', [BannerApiController::class, 'index']);
Route::get('/mall-banners', [MallBannerApiController::class, 'index']);

/* ===========================
| 💬 Delni Taxi Chat API
|=========================== */
use App\Http\Controllers\TaxiMessageController;

// ✅ جلب جميع الرسائل لطلب محدد
Route::get('/taxi/messages/{order_id}', [TaxiMessageController::class, 'index']);

// ✅ إرسال رسالة جديدة (راكب أو سائق)
Route::post('/taxi/messages', [TaxiMessageController::class, 'store']);

// ✅ جلب الرسائل عند التحديث (احتياط)
Route::post('/taxi/messages/fetch', [TaxiMessageController::class, 'fetch']);
