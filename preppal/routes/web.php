<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;

use App\Models\Product;


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
    $products = Product::all();
    return view('frontend.store', compact('products'));
})->name('store');


Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.delete');
});

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



