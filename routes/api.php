<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth')->group(function () {
    Route::get('/fertilizers', [StockApiController::class, 'index'])->name('api.fertilizers.index');
    Route::get('/fertilizers/{id}', [StockApiController::class, 'show'])->name('api.fertilizers.show');
});