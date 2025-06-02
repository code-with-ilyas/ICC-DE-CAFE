<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseReportController;
use App\Http\Controllers\PurchaseStockController;
use App\Http\Controllers\ReportController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('purchase_stocks', PurchaseStockController::class);
        Route::resource('expenses', ExpenseController::class);
        Route::resource('orders', OrderController::class);

        Route::post('/orders/filter', [OrderController::class, 'filter'])->name('orders.filter');
        Route::post('/orders/{id}/apply-discount', [OrderController::class, 'applyDiscount'])->name('orders.applyDiscount');
        Route::get('/orders/{id}/print', [OrderController::class, 'print'])->name('orders.print');
        Route::get('/orders/{order}/kitchen-print', [OrderController::class, 'kitchenPrint'])->name('orders.kitchen.print');
        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
        Route::get('/purchase-reports', [PurchaseReportController::class, 'index'])->name('purchase.reports.index');
    });

    // Client routes
    Route::middleware('client')->group(function () {
        Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');

        Route::resource('orders', OrderController::class)->only([
            'index',
            'create',
            'store',
            'edit',
            'update',
            'show'
        ]);

        Route::get('/orders/{id}/print', [OrderController::class, 'print'])->name('orders.print');
        Route::get('/orders/{order}/kitchen-print', [OrderController::class, 'kitchenPrint'])->name('orders.kitchen.print');

        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    });
});

require __DIR__ . '/auth.php';
