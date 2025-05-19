<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\AuthController;

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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
});
