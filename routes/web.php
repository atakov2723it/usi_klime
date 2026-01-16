<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('catalog.index')
        : redirect()->route('login');
});

// USE-CASE (public)
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

// USE-CASE (auth)
Route::post('/checkout', [CheckoutController::class, 'store'])
    ->middleware('auth')
    ->name('checkout.store');

Route::get('/my-orders', [OrderController::class, 'myOrders'])
    ->middleware('auth')
    ->name('orders.mine');

Route::get('/servis', [ServiceRequestController::class, 'create'])
    ->middleware('auth')
    ->name('service.create');

Route::post('/servis', [ServiceRequestController::class, 'store'])
    ->middleware('auth')
    ->name('service.store');

// Profile/Dashboard (Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ADMIN CRUD (sve) - samo admin vidi
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('order-items', OrderItemController::class);
        Route::resource('service-requests', ServiceRequestController::class);
    });

Route::get('/servis', [ServiceRequestController::class, 'create'])
    ->middleware('auth')
    ->name('service.create');

Route::post('/servis', [ServiceRequestController::class, 'store'])
    ->middleware('auth')
    ->name('service.store');

require __DIR__.'/auth.php';
