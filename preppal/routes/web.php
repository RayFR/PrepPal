<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Home page
Route::get('/', function () {
    return view('frontend.index');
})->name('home');

// Calculator page
Route::get('/calculator', function () {
    return view('frontend.calculator');
})->name('calculator');

// Store page
Route::get('/store', function () {
    return view('frontend.store');
})->name('store');


// Auth pages
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/register', [AuthController::class, 'register'])->name('register');


// Dashboard (auth required)
Route::get('/dashboard', [AuthController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');