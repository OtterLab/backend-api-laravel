<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\GetAuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\RoomCapacityController;
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

Route::prefix('customer')->group(function () {
    Route::post('createCustomer', [CustomerController::class, 'createCustomer']);
    Route::put('updateCustomer/{id}', [CustomerController::class, 'updateCustomer']);
    Route::get('showAllCustomers', [CustomerController::class, 'showAllCustomers']);
    Route::get('getCustomer/{id}', [CusomterController::class, 'getCustomer']);
    Route::delete('deleteCustomer/{id}', [CustomerController::class, 'deleteCustomer']);
});

Route::prefix('hotel')->group(function () {
    Route::post('createHotel', [HotelController::class, 'createHotel']);
    Route::put('updateHotel/{id}', [HotelController::class, 'updateHotel']);
    Route::get('showAllHotels', [HotelController::class, 'showAllHotels']);
    Route::get('getHotel/{id}', [HotelController::class, 'getHotel']);
    Route::delete('deleteHotel/{id}', [HotelController::class, 'deleteHotel']);
});

Route::prefix('price')->group(function () {
    Route::post('createPrice', [PriceController::class, 'createPrice']);
    Route::put('updatePrice/{id}', [PriceController::class, 'updatePrice']);
    Route::get('showAllPrices', [PriceController::class, 'showAllPrices']);
    Route::get('pricesFiltered', [PriceController::class, 'pricesFiltered']);
    Route::get('getPrice/{id}', [PriceController::class, 'getPrice']);
    Route::delete('deletePrice/{id}', [PriceController::class, 'deletePrice']);
});

Route::prefix('room_capacity')->group(function () {
    Route::post('createRoomCapacity', [RoomCapacityController::class, 'createPrice']);
    Route::put('updateRoomCapacity/{id}', [RoomCapacityController::class, 'updateRoomCapacity']);
    Route::get('showAllRoomCapacities', [RoomCapacityController::class, 'showAllRoomCapacities']);
    Route::get('getRoomCapacity/{id}', [RoomCapacityController::class, 'getRoomCapacity']);
    Route::delete('deleteRoomCapacity/{id}', [RoomCapacityController::class, 'deleteRoomCapacity']);
});