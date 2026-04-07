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

    // Dashboard - Admin only
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware(['admin', 'role:admin']);

    // Product Management - Admin only
    Route::resource('products', ProductController::class)->middleware(['admin', 'role:admin']);

    // Orders Management - Admin & Cashier & Kitchen
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware(['admin', 'role:admin,cashier,kitchen']);
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit')->middleware(['admin', 'role:admin,cashier,kitchen']);
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update')->middleware(['admin', 'role:admin,cashier,kitchen']);
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware(['admin', 'role:admin']);
    
    // Cashier Features - Admin & Cashier
    Route::get('/orders/{id}/payment', [OrderController::class, 'updatePayment'])->name('orders.payment')->middleware(['admin', 'role:admin,cashier']);
    Route::post('/orders/{id}/payment', [OrderController::class, 'updatePaymentStatus'])->middleware(['admin', 'role:admin,cashier']);
    Route::get('/orders/{id}/receipt', [OrderController::class, 'printReceipt'])->name('orders.receipt')->middleware(['admin', 'role:admin,cashier,kitchen']);
    Route::get('/walkthrough', [OrderController::class, 'walkthroughCreate'])->name('orders.walkthrough.create')->middleware(['admin', 'role:admin,cashier']);
    Route::post('/walkthrough', [OrderController::class, 'walkthroughStore'])->name('orders.walkthrough.store')->middleware(['admin', 'role:admin,cashier']);

    // Kitchen View - Admin & Kitchen
    Route::get('/kitchen', [OrderController::class, 'kitchen'])->name('kitchen')->middleware(['admin', 'role:admin,kitchen']);
    
    // Order History - All roles
    Route::get('/history', [OrderController::class, 'history'])->name('history')->middleware(['admin', 'role:admin,kitchen,cashier']);
});
