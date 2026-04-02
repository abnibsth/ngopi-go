<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

// Home
Route::get('/', function () {
    return redirect()->route('order.create');
});

// Customer Routes
Route::get('/pesan/{tableNumber?}', [OrderController::class, 'create'])->name('order.create');
Route::post('/pesan', [OrderController::class, 'store'])->name('order.store');
Route::get('/pesanan/{orderNumber}', [OrderController::class, 'show'])->name('order.success');
Route::get('/pembayaran/{order}', [OrderController::class, 'payment'])->name('order.payment');
Route::post('/midtrans/callback', [OrderController::class, 'midtransCallback'])->name('midtrans.callback');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth Routes (Public)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard (Protected)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('admin');
    
    // Product Management (Protected)
    Route::resource('products', ProductController::class)->middleware('admin');
    
    // Orders (Protected)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('admin');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit')->middleware('admin');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update')->middleware('admin');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware('admin');
    
    // Kitchen View (Protected)
    Route::get('/kitchen', [OrderController::class, 'kitchen'])->name('kitchen')->middleware('admin');
});
