<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PurchaseStockController;
use App\Http\Controllers\ProductIngredientController;
use App\Http\Controllers\StockMovementController;


use Illuminate\Support\Facades\Route;

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
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders/filter', [OrderController::class, 'filter'])->name('orders.filter');
Route::post('/orders/{id}/apply-discount', [OrderController::class, 'applyDiscount'])->name('orders.applyDiscount');
Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
Route::get('/orders/{id}/print', [OrderController::class, 'print'])->name('orders.print');






// Ingredients Routes
Route::resource('ingredients', IngredientController::class);
Route::get('ingredients-stock', [IngredientController::class, 'stock'])->name('ingredients.stock');

// Purchase Stock Routes
Route::resource('purchase-stocks', PurchaseStockController::class);



Route::resource('products.ingredients', ProductIngredientController::class)->except(['show']);


// Stock Movements
Route::get('stock-movements', [StockMovementController::class, 'index'])->name('stock-movements.index');
Route::get('stock-movements/{ingredient}', [StockMovementController::class, 'ingredientMovements'])
    ->name('stock-movements.ingredient');





// Dashboard
Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');
