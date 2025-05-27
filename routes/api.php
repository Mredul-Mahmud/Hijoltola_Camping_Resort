<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Package\PackageController;
use App\Http\Controllers\Food\FoodController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Booking\BookingController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//Packages//
Route::get('allPackages',[PackageController::class,'packageList']);
Route::post('addPackage',[PackageController::class,'addPackage']);
Route::put('editPackage', [PackageController::class, 'editPackage']);
Route::get('/packageDetail/{id}', [PackageController::class, 'findPackageById']);
Route::delete('deletePackage/{id}',[PackageController::class,'deletePackage']);
Route::get('searchPackage/{search}',[PackageController::class,'searchPackage']);

//Foods//
Route::get('allFoods',[FoodController::class,'foodList']);
Route::post('addFood',[FoodController::class,'addFood']);
Route::put('editFood', [FoodController::class, 'editFood']);
Route::get('/foodDetail/{id}', [FoodController::class, 'getFoodById']);
Route::delete('deleteFood/{id}',[FoodController::class,'deleteFood']);
Route::get('searchFood/{search}',[FoodController::class,'searchFood']);




//Auth//
Route::post('register', [AuthController::class, 'register'])->middleware('api.loggedUser');
Route::post('login', [AuthController::class, 'login'])->middleware('api.loggedUser');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('book-package/{package_id}', [BookingController::class, 'bookPackage']);
    Route::put('/bookings/edit/{booking_id}', [BookingController::class, 'editBooking']);
    Route::delete('/bookings/delete/{booking_id}', [BookingController::class, 'deleteBooking']);
    Route::get('/bookings/details/{booking_id}', [BookingController::class, 'bookingDetail']);
    Route::get('/bookings', [BookingController::class, 'allBooking']);
    Route::get('/bookings/search', [BookingController::class, 'searchBooking']);
});
Route::prefix('auth')->group(function () {
    Route::get('google/redirect', [GoogleAuthController::class, 'redirectToGoogle']);
    Route::get('google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
    Route::get('facebook/redirect', [FacebookAuthController::class, 'redirectToFacebook']);
    Route::get('facebook/callback', [FacebookAuthController::class, 'handleFacebookCallback']);

});
