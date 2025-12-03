<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// home/index page
Route::get('/', function () {
    return view('frontend.home');
})->name('home');

// calc page
Route::get('/calculator', function () {
    return view('frontend.calculator');
})->name('calculator');

// store page
Route::get('/store', function () {
    return view('frontend.store');
})->name('store');

// store page
Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');

// checkout page
Route::get('/checkout', function () {
    return view('frontend.checkout');
})->name('checkout');

Route::post('/checkout', [CheckoutController::class, 'store'])
    ->middleware('auth');

// Auth pages
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/register', [AuthController::class, 'register'])->name('register');


// Dashboard (auth required)
Route::get('/dashboard', [AuthController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');