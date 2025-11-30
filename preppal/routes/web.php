<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// showing/GET forms
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// actions/POST requests
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// protected routes
Route::get('/dashboard', [AuthController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');