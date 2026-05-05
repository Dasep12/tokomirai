<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Semua cache berhasil dibersihkan!";
});

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/product-json', [HomeController::class, 'productJson'])->name('home.product-json');
// Route::get('/product-json-detail', [HomeController::class, 'productJsonDetail'])->name('home.product-json-detail');
Route::get('/product-json-detail', [HomeController::class, 'productListJsonDetail'])->name('home.product-json-detail');

Route::post('/cart/add', [HomeController::class, 'add'])->name('cart.add');
Route::get('/cart', [HomeController::class, 'get'])->name('cart.get');
Route::post('/cart/update', [HomeController::class, 'update'])->name('cart.update');
