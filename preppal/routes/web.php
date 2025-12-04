<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;

// home/index page
Route::get('/', function () {
    return view('frontend.home');
})
->name('home');


// calc page
Route::get('/calculator', function () {
    return view('frontend.calculator');
})
->middleware('auth')
->name('calculator');

// store page
Route::get('/store', function () {
    return view('frontend.store');
})
->middleware('auth')
->name('store');

// contact page (correct controller version)
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// checkout page
Route::get('/checkout', function () {
    return view('frontend.checkout');
})
->middleware('auth')
->name('checkout');

Route::post('/checkout', [CheckoutController::class, 'store'])
->middleware('auth');

// Auth pages
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/register', [AuthController::class, 'register'])->name('register');



