<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\DishController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'verified'])->name('admin.')->prefix('admin/{user_slug}')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('restaurants', RestaurantController::class)->parameters(['restaurants' => 'restaurant_slug']);

    //http://127.0.0.1:8000/admin/valerio-cdddd/restaurants/da-zio-luciano-1
    Route::resource('dishes', RestaurantController::class)->parameters(['dishes' => 'dish_slug']);
    //http://127.0.0.1:8000/admin/valerio-cdddd/dishes/pizza-margherita
    Route::resource('restaurants/{restaurant_slug}/dishes', DishController::class)->parameters(['dishes' => 'dish_slug']);
    //http://127.0.0.1:8000/admin/valerio-cdddd/restaurants/da-zio-luciano-1/dishes/pizza-margherita
    Route::get('restaurants/{restaurant_slug}/orders', [OrderController::class, 'showBills'])->name('orders.showBills');


    //altre rotte...
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::fallback(function () {
    if (Auth::check()) {
        $data = [
            'user_slug' => Auth::user()->slug
        ];
        return redirect()->route('admin.dashboard', $data);
    }
});
