<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\AdApiController;

Route::post('/login',    [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/my-ads', [AdApiController::class, 'myAds']);
    Route::post('/ads',   [AdApiController::class, 'store']);
    Route::get('/ads',    [AdApiController::class, 'index']);
    Route::put('/ads/{id}', [AdApiController::class, 'update']);
    Route::delete('/ads/{id}', [AdApiController::class, 'destroy']);
});
