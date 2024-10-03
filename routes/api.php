<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\JwtMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

 
Route::get('/example', function () {
    return response()->json(['message' => 'Hello, API!']);
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::middleware(JwtMiddleware::class)->prefix('')->name('api.')->controller(AuthController::class)->group(function () {
    Route::post('/update-profile', 'update-profile')->name('update');
});
Route::middleware(JwtMiddleware::class)->prefix('')->name('api.')->controller(AuthController::class)->group(function () {
    Route::post('/userdata', 'userdata')->name(name: 'userdata');
});
Route::middleware(JwtMiddleware::class)->prefix('')->name('api.')->controller(AuthController::class)->group(function () {
    Route::post('/update-image', 'update_profile_image')->name(name: 'update-image');
});
Route::middleware(JwtMiddleware::class)->prefix('')->name('api.')->controller(AuthController::class)->group(function () {
    Route::post('/update-profile', 'update_profile');
});