<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\AdApiController;
use App\Http\Controllers\API\DriverAuthApiController;

use App\Http\Controllers\TaxiController;
use App\Http\Controllers\TaxiOrderController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\Api\DriverApiController;

// Users auth
Route::post('/login',    [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);

// Taxi orders (API)
Route::post('/taxi-orders', [TaxiOrderController::class, 'apiStore'])->name('api.taxi.orders.store');

// Ads (public)
Route::get('/ads', [AdApiController::class, 'index']);

// Drivers list + driver location
Route::get('/drivers', [DriverApiController::class, 'index'])->name('api.drivers.index');
Route::get('/driver-location/{id}', [TaxiController::class, 'driverLocation'])->name('api.driver.location');
Route::post('/driver-location/{id}', [TaxiController::class, 'updateDriverLocation'])
    ->middleware(['auth.driver','throttle:30,1'])
    ->name('api.driver.location.update');

// Legacy update-location (kept for backward compatibility)
Route::post('/driver/update-location', [DriverController::class, 'updateLocation'])
    ->middleware(['auth.driver','throttle:30,1'])
    ->name('api.driver.update.location.legacy');

// Token-based optional endpoint (Sanctum)
Route::middleware(['auth:sanctum','throttle:30,1'])
    ->post('/driver/update-location-token', [DriverController::class, 'updateLocation'])
    ->name('api.driver.update.location.token');

// Protected (users)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/my-ads', [AdApiController::class, 'myAds']);
    Route::post('/ads',   [AdApiController::class, 'store']);
    Route::put('/ads/{id}', [AdApiController::class, 'update']);
    Route::delete('/ads/{id}', [AdApiController::class, 'destroy']);
});

// Drivers auth
Route::post('/driver/register', [DriverAuthApiController::class, 'register']);
Route::post('/driver/login',    [DriverAuthApiController::class, 'login']);
Route::post('/driver/logout',   [DriverAuthApiController::class, 'logout'])->middleware('auth.driver');

// Protected (drivers)
Route::middleware('auth.driver')->prefix('driver')->group(function () {
    Route::get('/me', fn (Request $request) => $request->user());
    Route::post('/update-location', [DriverController::class, 'updateLocation'])->middleware('throttle:30,1')
        ->name('api.driver.update.location');
});

Route::get('/health', fn () => response()->json([
    'ok' => true,
    'time' => now()->toISOString(),
]));
