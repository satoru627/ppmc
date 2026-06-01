<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques visiteur
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/apropos', [HomeController::class, 'about'])->name('about');
Route::get('/catalogue', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/training', [HomeController::class, 'training'])->name('training');
Route::get('/service', [HomeController::class, 'service'])->name('service');
Route::get('/service/{platform}', [HomeController::class, 'servicePlatform'])
    ->where('platform', 'tiktok|facebook|youtube')
    ->name('service.platform');
Route::get('/crypto', [HomeController::class, 'legacyCrypto'])->name('legacy.crypto');
Route::get('/formations', [HomeController::class, 'formations'])->name('formations');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/produits/{product:slug}', [HomeController::class, 'show'])->name('products.show');
Route::get('/produits/{product:slug}/acheter', [HomeController::class, 'buy'])->name('products.buy');
Route::get('/download/{token}', DownloadController::class)
    ->middleware('signed')
    ->name('orders.download');

Route::middleware('guest')->group(function (): void {
    Route::get('/admin/login', [LoginController::class, 'create'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'store'])->middleware('throttle:10,1');
});

/*
|--------------------------------------------------------------------------
| Routes protegees session
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Routes administrateur
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', AdminMiddleware::class])
    ->group(function (): void {
        Route::redirect('/', '/admin/products')->name('home');
        Route::redirect('/dashboard', '/admin/products');

        Route::resource('products', AdminProductController::class)->except(['show']);

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/block', [AdminUserController::class, 'block'])->name('users.block');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });
