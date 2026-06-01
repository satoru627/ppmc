<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SupportTicketController as AdminSupportTicketController;
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
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:10,1');
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
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/stats', [AdminDashboardController::class, 'stats'])->name('stats');

        Route::resource('products', AdminProductController::class)->except(['show']);

        Route::get('/orders/chariow-sale', [AdminOrderController::class, 'createChariowSale'])->name('orders.chariow.create');
        Route::post('/orders/chariow-sale', [AdminOrderController::class, 'storeChariowSale'])->name('orders.chariow.store');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::post('/orders/{order}/send', [AdminOrderController::class, 'send'])->name('orders.send');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/block', [AdminUserController::class, 'block'])->name('users.block');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::get('/support', [AdminSupportTicketController::class, 'index'])->name('support.index');
        Route::get('/support/{ticket}', [AdminSupportTicketController::class, 'show'])->name('support.show');
        Route::patch('/support/{ticket}/status', [AdminSupportTicketController::class, 'updateStatus'])->name('support.status');
    });
