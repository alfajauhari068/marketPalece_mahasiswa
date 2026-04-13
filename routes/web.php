<?php

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

Route::get('/', function () {
    return view('login');
});

Route::post('/', function (Illuminate\Http\Request $request) {
    return back()->with('status', 'Login diproses');
})->name('login.post');

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', function (Illuminate\Http\Request $request) {
    return "Proses registrasi...";
})->name('register.post');