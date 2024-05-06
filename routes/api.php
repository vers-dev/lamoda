<?php

use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Reserve\ReserveController;
use Illuminate\Support\Facades\Route;

Route::get('/get-products', [ProductController::class, 'getProductsByStorageId']);

Route::post('/reserve-products', [ReserveController::class, 'reserveProducts']);
Route::post('/un-reserve-products', [ReserveController::class, 'unReserveProducts']);