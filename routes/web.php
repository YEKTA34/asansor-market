<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

Route::get('/', [ProductController::class, 'landing'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::any('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/deactivate', [AuthController::class, 'deactivate'])->name('profile.deactivate');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::any('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/checkout/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{id}/confirm-delivery', [OrderController::class, 'confirmDelivery'])->name('orders.confirm_delivery');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products/store', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/edit/{id}', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::post('/products/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::any('/products/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::any('/users/toggle/{id}', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle_status');
    Route::any('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::any('/orders/{id}/advance', [AdminController::class, 'advanceOrderStatus'])->name('admin.orders.advance');
});
