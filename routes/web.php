<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerQuotaController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerShopsController;

// Public Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register/owner', [AuthController::class, 'showOwnerRegisterForm'])->name('register.owner');
Route::get('/register/customer', [AuthController::class, 'showCustomerRegisterForm'])->name('register.customer');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/',function () {
    return view('welcome');
});



// Shared Auth Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Owner Routes
Route::middleware(['auth', 'owner'])->prefix('owner')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');

});

// Customer Routes
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::get('/profile', [CustomerProfileController::class, 'show'])->name('customer.profile.show');
    Route::get('/profile/edit', [CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::post('/profile/update', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
    Route::get('/quota', [CustomerQuotaController::class, 'index'])->name('customer.quotas.index');
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/orders/create', [CustomerOrderController::class, 'create'])->name('customer.orders.create');
    Route::post('/orders', [CustomerOrderController::class, 'store'])->name('customer.orders.store');
    Route::get('/shops', [CustomerShopsController::class, 'index'])->name('customer.shops.index');

});
