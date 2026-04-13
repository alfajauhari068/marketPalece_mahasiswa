<?php

use App\Http\Controllers\DashboardKlienController;
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

Route::post('/login', function (Illuminate\Http\Request $request) {
    return back()->with('status', 'Login diproses');
})->name('login.post');

Route::get('/',  [DashboardKlienController::class, 'index'])->name('dashboard-klien');