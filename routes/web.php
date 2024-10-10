<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Products\ShopController;
use App\Http\Controllers\Products\OrderController;
use App\Http\Controllers\Products\SellerController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware(['auth.jwt'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');



Route::middleware('auth')->group(function () {
    // Dashboard route
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/manage/products', [ProductController::class, 'manage'])->name('manage.products');
    Route::post('/cart/add', [ProductController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/clear', [ProductController::class, 'clear'])->name('cart.clear');
    Route::get('/order/history', [OrderController::class, 'history'])->name('order.history');
    Route::get('/password/change', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/update', [AuthController::class, 'update'])->name('password.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::prefix('api')->group(function () {
    Route::get('/products', [ProductController::class, 'showAllProductApi']);
    Route::get('/products/{id}', [ProductController::class, 'showProductApiById']);
});


Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/products/single/{id}', [ProductController::class, 'showsingleproduct'])->name('products.showsingleproduct');
Route::get('/cart', [ProductController::class, 'viewcart'])->name('cart.index');

