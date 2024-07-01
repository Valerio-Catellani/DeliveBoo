<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\RegisteredUserController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\DishController;
use App\Http\Controllers\Api\TypologyController;
use App\Http\Controllers\Api\OrderController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/registeruser', [RegisteredUserController::class, 'checkRegistration']);

Route::get('get-restaurants', [RestaurantController::class, 'findRestaurants']);
Route::get('get-restaurants/{slug}', [RestaurantController::class, 'findSingleRestaurant']);
Route::get('get-dishes', [DishController::class, 'findDishes']);
Route::get('get-dishes/{slug}', [DishController::class, 'findSingleDish']);
Route::get('get-orders', [OrderController::class, 'findOrders']);
Route::get('get-orders/{id}', [OrderController::class, 'findSingleOrder']);
Route::get('get-typologies', [TypologyController::class, 'findTypologies']);


