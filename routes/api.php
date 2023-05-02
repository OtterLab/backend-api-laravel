<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\GetAuthController;
use App\Http\Controllers\BookingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', [LogoutController::class, 'logout']);
        Route::get('getAuthUser', [GetAuthController::class, 'getAuthUser']);
    });
});

Route::prefix('booking')->group(function () {
    Route::post('createBooking', [BookingController::class, 'createBooking']);
    Route::put('updateBooking/{id}', [BookingController::class, 'updateBooking']);
    Route::get('showAllBookings', [BookingController::class, 'showAllBookings']);
    Route::get('getBooking/{id}', [BookingController::class, 'getBooking']);
    Route::delete('deleteBooking/{id}', [BookingController::class, 'deleteBooking']);
});