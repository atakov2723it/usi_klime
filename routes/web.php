<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('products', App\Http\Controllers\ProductController::class);

Route::resource('orders', App\Http\Controllers\OrderController::class);

Route::resource('order-items', App\Http\Controllers\OrderItemController::class);

Route::resource('service-requests', App\Http\Controllers\ServiceRequestController::class);
