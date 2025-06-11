<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Public Routes
Route::middleware('guest')->group(function () {
    Route::get('/',function () {
        return view('welcome');
    });
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register/owner', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::get('/register/customer', [AuthController::class, 'showRegistrationForm'])->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Shared Auth Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

});

// Customer Routes
Route::middleware(['auth', 'customer'])->group(function () {
});

// Owner Routes
Route::middleware(['auth', 'owner'])->prefix('owner')->group(function () {

});