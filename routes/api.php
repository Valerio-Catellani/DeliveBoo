<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\RegisteredUserController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\DishesController;

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

Route::get('get-restaurants', [RestaurantController::class, 'index']);
Route::get('get-restaurants/{slug}', [RestaurantController::class, 'show']);
Route::get('get-dishes', [DishesController::class, 'index']);
Route::get('get-dishes/{slug}', [DishesController::class, 'show']);
