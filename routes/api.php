<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdApiController;
use App\Http\Controllers\Api\AuthApiController;

// ✅ تسجيل الدخول والتسجيل API
Route::post('/login',    [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);

// ✅ مستخدم عام (اختبار)
Route::get('/user', fn() => response()->json(['message' => 'Public user endpoint']));

// ✅ الإعلانات API
Route::get('/ads', [AdApiController::class, 'index']);
Route::get('/ads/{id}', [AdApiController::class, 'show']);
Route::post('/ads', [AdApiController::class, 'store'])->middleware('auth:sanctum');
Route::put('/ads/{id}', [AdApiController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/ads/{id}', [AdApiController::class, 'destroy'])->middleware('auth:sanctum');
Route::put('/ads/{id}/merge', [AdApiController::class, 'updateMerge'])->middleware('auth:sanctum');

// ✅ إعلاناتي عبر API
Route::get('/my-ads', [AdApiController::class, 'myAds'])->middleware('auth:sanctum'); // ✅ تصحيح هنا
