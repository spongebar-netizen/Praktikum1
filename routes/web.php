<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/about', function () {
    return view('about');
})->middleware(['auth', 'verified'])->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product Page
    Route::get('/product/export', function () {
        return "Export Successful! This route is protected by export-product Gate.";
    })->middleware('can:export-product')->name('product.export');
    
    Route::get('/product', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
    Route::post('/product', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
    Route::get('/product/create', [App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
    Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
    Route::put('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
    Route::get('/product/edit/{product}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
    Route::delete('/product/delete/{id}', [App\Http\Controllers\ProductController::class, 'delete'])->name('product.delete');

    // Category Routes (Protected by manage-categories Gate)
    Route::middleware('can:manage-categories')->group(function () {
        Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    });
});

require __DIR__.'/auth.php';
