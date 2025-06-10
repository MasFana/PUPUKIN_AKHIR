<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Public Routes
Route::middleware('guest')->group(function () {
});

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