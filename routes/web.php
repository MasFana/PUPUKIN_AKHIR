<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\OwnerTransactionController;
use App\Http\Controllers\OwnerProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerQuotaController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerShopsController;
use App\Http\Controllers\OwnerStockController;
use App\Http\Controllers\AdminStockController;

// Public Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register/owner', [AuthController::class, 'showOwnerRegisterForm'])->name('register.owner');
Route::get('/register/customer', [AuthController::class, 'showCustomerRegisterForm'])->name('register.customer');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/',function () {
    return view('welcome');
})->name('landing');



// Shared Auth Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});



// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::prefix('/stocks')->group(function () {
        Route::get('/', [AdminStockController::class, 'index'])->name('admin.stocks.index');
        Route::post('/{id}', [AdminStockController::class, 'update'])->name('admin.stocks.update');
    });
});

// Owner Routes
Route::middleware(['auth', 'owner'])->prefix('owner')->group(function () {
    Route::get('/', [OwnerController::class, 'index'])->name('owner.dashboard');
    Route::group(['prefix' => 'transactions'], function () {
        Route::get('/', [OwnerTransactionController::class, 'index'])->name('owner.transactions.index');
        // Route::get('/{id}', [OwnerTransactionController::class, 'show'])->name('owner.transactions.show');
        Route::post('/{id}/complete', [OwnerTransactionController::class, 'completed'])->name('owner.transactions.completed');
        Route::post('/{id}/cancel', [OwnerTransactionController::class, 'canceled'])->name('owner.transactions.canceled');
    });
    Route::prefix('/profile')->group(function () {
        Route::get('/', [OwnerProfileController::class, 'show'])->name('owner.profile.show');
        Route::get('/edit', [OwnerProfileController::class, 'edit'])->name('owner.profile.edit');
        Route::post('/update', [OwnerProfileController::class, 'update'])->name('owner.profile.update');
    });
    Route::prefix('/stocks')->group(function () {
        Route::get('/', [OwnerStockController::class, 'index'])->name('owner.stocks.index');
        Route::post('/requests', [OwnerStockController::class, 'storeRequest'])->name('owner.stocks.requests.store');
        Route::delete('/requests/{id}', [OwnerStockController::class, 'destroyRequest'])->name('owner.stocks.requests.destroy');
        // Additional routes for stocks can be added here
    });
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
