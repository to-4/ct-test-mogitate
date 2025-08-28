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
    // 動的パス（/{productId} など）は静的パス（/register など）より下に記述することで、ルーティングの競合を防ぐ
    Route::get   ('/',                   [ProductController::class, 'index']   )->name('products.index');
    Route::get   ('/register',           [ProductController::class, 'create']  )->name('products.create');
    Route::get   ('/search',             [ProductController::class, 'index']   )->name('products.search'); // index と同じ
    Route::get   ('/{productId}',        [ProductController::class, 'show']    )->name('products.show');
    Route::put   ('/{productId}/update', [ProductController::class, 'update']  )->name('products.update');
    Route::delete('/{productId}/delete', [ProductController::class, 'destroy'] )->name('products.destroy');
    Route::post  ('/',                   [ProductController::class, 'store']   )->name('products.store');
});
