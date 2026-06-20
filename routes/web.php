<?php

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

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/login', function (Illuminate\Http\Request $request) {
    return back()->with('status', 'Login diproses');
})->name('login.post');

Route::post('/register', function (Illuminate\Http\Request $request) {
    return back()->with('status', 'Pendaftaran diproses');
})->name('register.post');

Route::get('/',  [DashboardKlienController::class, 'index'])->name('dashboard-klien');

Route::get('/user',  [DashboardUserController::class, 'index'])->name('dashboard-user');

Route::get('/review/{order_id}', function ($order_id) {
    return "Review untuk order dengan ID: " . $order_id;
})->name('review');