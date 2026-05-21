<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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


Route::get('/register', [AuthController::class, 'register']);
Route::post('/register-process', [AuthController::class, 'registerProcess']);

Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login-process', [AuthController::class, 'loginProcess']);

Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/auth/google', [AuthController::class, 'googleRedirect']);
Route::get('/auth/google/callback', [AuthController::class, 'googleCallback']);


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


Route::middleware('auth')->group(function () {
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('cart.checkout');
    Route::get('/list-order', [HomeController::class, 'ListOrder'])->name('cart.list-order');
    Route::post('/order', [HomeController::class, 'order']);
});


Route::get('/product-json', [HomeController::class, 'productJson'])->name('home.product-json');
Route::get('/service-json', [HomeController::class, 'servicesJson'])->name('home.service-json');
// Route::get('/product-json-detail', [HomeController::class, 'productJsonDetail'])->name('home.product-json-detail');
Route::get('/product-json-detail', [HomeController::class, 'productListJsonDetail'])->name('home.product-json-detail');

Route::post('/cart/add', [HomeController::class, 'add'])->name('cart.add');
Route::get('/cart', [HomeController::class, 'get'])->name('cart.get');
Route::post('/cart/update', [HomeController::class, 'update'])->name('cart.update');


// Provinces
Route::get('/api/provinces', function () {
    return Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json')->json();
});

// Cities (Regencies)
Route::get('/api/cities/{id}', function ($id) {
    return Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/$id.json")->json();
});

// Districts
Route::get('/api/districts/{id}', function ($id) {
    return Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/districts/$id.json")->json();
});

// Villages
Route::get('/api/villages/{id}', function ($id) {
    return Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/villages/$id.json")->json();
});



// ADMIN ROUTES
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.home');
    Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'products'])->name('admin.products');
    Route::get('/products/detail', [App\Http\Controllers\Admin\ProductController::class, 'detail'])->name('admin.products.detail');
    Route::post('/products/crud', [App\Http\Controllers\Admin\ProductController::class, 'crud'])->name('admin.products.crud');
    Route::get('/products/loadcategory', [App\Http\Controllers\Admin\ProductController::class, 'loadcategory'])->name('admin.products.loadcategory');

    Route::get('/services', [App\Http\Controllers\Admin\ServiceController::class, 'services'])->name('admin.services');
    Route::get('/services/detail', [App\Http\Controllers\Admin\ServiceController::class, 'detail'])->name('admin.services.detail');
    Route::post('/services/crud', [App\Http\Controllers\Admin\ServiceController::class, 'crud'])->name('admin.services.crud');

    Route::get('/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'transactions'])->name('admin.transactions');
    Route::get('/transactions/detail', [App\Http\Controllers\Admin\TransactionController::class, 'detail'])->name('admin.transactions.detail');
    Route::post('/transactions/crud', [App\Http\Controllers\Admin\TransactionController::class, 'crud'])->name('admin.transactions.crud');

    Route::get('/customers', [App\Http\Controllers\Admin\TransactionController::class, 'customers'])->name('admin.customers');

    Route::get('/users', [App\Http\Controllers\Admin\UsersController::class, 'user'])->name('admin.users');
    Route::get('/users/detail', [App\Http\Controllers\Admin\UsersController::class, 'detail'])->name('admin.users.detail');
    Route::post('/users/crud', [App\Http\Controllers\Admin\UsersController::class, 'crud'])->name('admin.users.crud');

    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings');
    Route::get('/settings/detail', [App\Http\Controllers\Admin\SettingsController::class, 'detail'])->name('admin.settings.detail');
    Route::post('/settings/crud', [App\Http\Controllers\Admin\SettingsController::class, 'crud'])->name('admin.settings.crud');
});
