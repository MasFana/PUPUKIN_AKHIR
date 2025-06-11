<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/owners/{ownerId}/fertilizers-with-stock', [StockApiController::class, 'getOwnerFertilizers'])
    ->name('api.owners.fertilizers');
