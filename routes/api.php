<?php

use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Reserve\ReserveController;
use Illuminate\Support\Facades\Route;

Route::get('/get-products', [ProductController::class, 'getProductsByStorageId'])->name('get-products');

Route::post('/reserve-products', [ReserveController::class, 'reserveProducts'])->name('reserve-products');
Route::post('/un-reserve-products', [ReserveController::class, 'unReserveProducts'])->name('un-reserve-products');