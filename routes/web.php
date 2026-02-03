<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\IngredientCalculationController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\StockDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reports
    Route::get('/reports/sales-summary', [ReportController::class, 'salesSummary'])->name('reports.sales_summary');

    // Admin routes
    Route::middleware('admin')->group(function () {

        Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('expenses', ExpenseController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('ingredient_calculations', IngredientCalculationController::class);
        Route::get('/ingredients/pdf', [IngredientCalculationController::class, 'downloadPdf'])->name('ingredients.pdf');

        // Stock Dashboard
        Route::prefix('dashboard')->group(function () {
            Route::get('stocks', [StockDashboardController::class, 'index'])->name('dashboard.stocks');
        });

        Route::resource('stocks', StockController::class);
        Route::resource('product-stock', ProductStockController::class);

        // Orders extra actions
        Route::post('/orders/filter', [OrderController::class, 'filter'])->name('orders.filter');
        Route::post('/orders/{id}/apply-discount', [OrderController::class, 'applyDiscount'])->name('orders.applyDiscount');
        Route::get('/orders/{id}/print', [OrderController::class, 'print'])->name('orders.print');
        Route::get('/orders/{order}/kitchen-print', [OrderController::class, 'kitchenPrint'])->name('orders.kitchen.print');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
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

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});

require __DIR__ . '/auth.php';
