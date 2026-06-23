<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardClientController;
use App\Http\Controllers\DashboardKlienController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerServiceController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerReviewController;
use App\Http\Controllers\Seller\SellerEarningController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;
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

    Route::prefix('seller')->name('seller.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

        // Services CRUD
        Route::get('/services', [SellerServiceController::class, 'index'])->name('services.index');
        Route::get('/services/create', [SellerServiceController::class, 'create'])->name('services.create');
        Route::post('/services', [SellerServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}/edit', [SellerServiceController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [SellerServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [SellerServiceController::class, 'destroy'])->name('services.destroy');

        // Orders
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');

        // Reviews
        Route::get('/reviews', [SellerReviewController::class, 'index'])->name('reviews.index');

        // Earnings
        Route::get('/earnings', [SellerEarningController::class, 'index'])->name('earnings.index');

        // Profile and Settings
        Route::get('/profile', [SellerDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile/photo', [SellerDashboardController::class, 'updateProfilePhoto'])->name('profile.photo');
        Route::get('/settings', [SellerDashboardController::class, 'settings'])->name('settings');
    });

    Route::get('/seller', function () {
        return redirect()->route('seller.dashboard');
    })->name('seller.home');

    Route::get('/services/{service}', [ServiceController::class, 'show'])
        ->name('services.show');

    Route::get('/checkout/{service}', [CheckoutController::class, 'create'])
        ->name('checkout.create');
    Route::post('/checkout/{service}', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    // Payment routes
    Route::get('/payment/{order}', [PaymentController::class, 'show'])
        ->name('payment.show');
    Route::post('/payment/{order}', [PaymentController::class, 'process'])
        ->name('payment.process');
    Route::get('/payment/success/{order}', [PaymentController::class, 'success'])
        ->name('payment.success');
    Route::get('/payment/failed/{order}', [PaymentController::class, 'failed'])
        ->name('payment.failed');

    // Invoice routes
    Route::get('/invoice/{order}', [InvoiceController::class, 'show'])
        ->name('invoice.show');
    Route::get('/invoice/{order}/download', [InvoiceController::class, 'download'])
        ->name('invoice.download');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardClientController::class, 'index'])->name('home');
        Route::get('/search', [DashboardClientController::class, 'search'])->name('search');
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