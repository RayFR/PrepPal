<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BlogController;

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->name('newsletter.subscribe');

// HOME (public)
Route::get('/', [HomeController::class, 'index'])->name('home');

// CONTACT (public)
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// AUTH (public)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.forgot');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// PROTECTED PAGES
Route::middleware('auth')->group(function () {

    Route::get('/store', [ProductController::class, 'index'])->name('store');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/calculator', function () {
        return view('frontend.calculator');
    })->name('calculator');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // CHECKOUT
    Route::get('/checkout', function () {
        return view('frontend.checkout');
    })->name('checkout');

    Route::post('/checkout', [CheckoutController::class, 'store']);
    Route::get('/checkout/confirmation', [CheckoutController::class, 'confirmation'])
        ->name('checkout.confirmation');

    // CART
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.delete');
});

// ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Customers
    Route::get('/customers', [AdminCustomerController::class, 'index'])
        ->name('admin.customers.index');
    Route::get('/customers/{user}/edit', [AdminCustomerController::class, 'edit'])
        ->name('admin.customers.edit');
    Route::put('/customers/{user}', [AdminCustomerController::class, 'update'])
        ->name('admin.customers.update');
    Route::delete('/customers/{user}', [AdminCustomerController::class, 'destroy'])
        ->name('admin.customers.destroy');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
        ->name('admin.orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('admin.orders.updateStatus');

    // Products / Inventory
    Route::get('/products', [AdminProductController::class, 'index'])
        ->name('admin.products.index');

    Route::get('/products/create', [AdminProductController::class, 'create'])
        ->name('admin.products.create');

    Route::post('/products', [AdminProductController::class, 'store'])
        ->name('admin.products.store');

    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])
        ->name('admin.products.edit');

    Route::put('/products/{product}', [AdminProductController::class, 'update'])
        ->name('admin.products.update');

    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])
        ->name('admin.products.destroy');

    Route::post('/products/{product}/stock/add', [AdminProductController::class, 'addStock'])
        ->name('admin.products.addStock');

    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
});

// REVIEWS
Route::middleware('auth')->group(function () {
    Route::post('/products/{id}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])
        ->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])
        ->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');
});