<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('products')->group(function () {
    // == 20250827 == //
    // Route::get   ('/',                   [ProductController::class, 'index']   )->name('products.index');
    // Route::get   ('/{productId}',        [ProductController::class, 'detail']  )->name('products.detail');
    // Route::put   ('/{productId}/update', [ProductController::class, 'update']  )->name('products.update');
    // Route::delete('/{productId}/delete', [ProductController::class, 'destroy'] )->name('products.destroy');
    // Route::get   ('/register',           [ProductController::class, 'register'])->name('products.register');

    Route::get   ('/',                   [ProductController::class, 'index']   )->name('products.index');
    Route::get   ('/{productId}',        [ProductController::class, 'show']    )->name('products.show');
    Route::put   ('/{productId}/update', [ProductController::class, 'update']  )->name('products.update');
    Route::delete('/{productId}/delete', [ProductController::class, 'destroy'] )->name('products.destroy');
    Route::get   ('/register',           [ProductController::class, 'create']  )->name('products.create');
    Route::post  ('/',                   [ProductController::class, 'store']   )->name('products.store');
    // == 20250827 == //
});
