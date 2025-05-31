<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseStockController;
use App\Http\Controllers\PurchaseReportController;
use App\Http\Controllers\ExpenseController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('categories', CategoryController::class);
Route::resource('orders', OrderController::class);
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders/filter', [OrderController::class, 'filter'])->name('orders.filter');
Route::post('/orders/{id}/apply-discount', [OrderController::class, 'applyDiscount'])->name('orders.applyDiscount');
Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
Route::get('/orders/{id}/print', [OrderController::class, 'print'])->name('orders.print');


Route::get('/orders/{order}/kitchen-print', [OrderController::class, 'kitchenPrint'])->name('orders.kitchen.print');





Route::resource('products', ProductController::class);


Route::resource('purchase_stocks', PurchaseStockController::class);


Route::get('/purchase-reports', [PurchaseReportController::class, 'index'])->name('purchase.reports.index');




Route::resource('expenses', ExpenseController::class);


require __DIR__ . '/auth.php';
