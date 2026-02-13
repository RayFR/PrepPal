<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;


use App\Http\Controllers\CartController;



// HOME (public)
Route::get('/', [HomeController::class, 'index'])->name('home');

// CONTACT (public)
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// AUTH (public)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// PROTECTED PAGES (must be logged in)
Route::middleware('auth')->group(function () {

    // STORE + PRODUCT PAGES
    Route::get('/store', [ProductController::class, 'index'])->name('store');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // CALCULATOR
    Route::get('/calculator', function () {
        return view('frontend.calculator');
    })->name('calculator');

    // CHECKOUT
    Route::get('/checkout', function () {
        return view('frontend.checkout');
    })->name('checkout');

    Route::post('/checkout', [CheckoutController::class, 'store']);

    // CART (only keep if you actually have CartController)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.delete');
});
