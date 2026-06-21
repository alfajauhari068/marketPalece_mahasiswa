<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardClientController;
use App\Http\Controllers\DashboardKlienController;
use App\Http\Controllers\DashboardUserController;
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

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware(['auth'])->group(function () {
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/seller', [DashboardUserController::class, 'index'])->name('seller.home');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardClientController::class, 'index'])->name('home');
        Route::get('/orders', [DashboardClientController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [DashboardClientController::class, 'orderDetail'])->name('order.detail');
        Route::get('/messages', [DashboardClientController::class, 'messages'])->name('messages');
        Route::get('/messages/{id}', [DashboardClientController::class, 'messageDetail'])->name('message.detail');
        Route::get('/notifications', [DashboardClientController::class, 'notifications'])->name('notifications');
        Route::get('/profile', [DashboardClientController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [DashboardClientController::class, 'profileEdit'])->name('profile.edit');
        Route::post('/profile/edit', [DashboardClientController::class, 'profileUpdate'])->name('profile.update');
    });
});

Route::get('/',  [DashboardKlienController::class, 'index'])->name('dashboard-klien');

Route::get('/user',  [DashboardUserController::class, 'index'])->name('dashboard-user');

Route::get('/review/{order_id}', function ($order_id) {
    return "Review untuk order dengan ID: " . $order_id;
})->name('review');