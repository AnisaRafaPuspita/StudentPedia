<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\DashboardSellerController;
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

/*
|---------------- SELLER ROUTES ----------------
*/
Route::middleware('auth')->group(function () {

    // route utama
    Route::get('/seller/dashboard', [DashboardSellerController::class, 'index'])
        ->name('seller.dashboard');

    // alias supaya URL /dashboardPenjual juga bisa dipakai
    Route::get('/dashboardPenjual', [DashboardSellerController::class, 'index'])
        ->name('seller.dashboardPenjual');

    // CRUD Produk
    Route::post('/seller/products', [DashboardSellerController::class, 'store'])
        ->name('seller.products.store');

    Route::get('/seller/products/{id}/edit', [DashboardSellerController::class, 'edit'])
        ->name('seller.products.edit');

    Route::put('/seller/products/{id}', [DashboardSellerController::class, 'update'])
        ->name('seller.products.update');

    Route::delete('/seller/products/{id}', [DashboardSellerController::class, 'destroy'])
        ->name('seller.products.destroy');
    
    Route::get('/seller/products/create', [DashboardSellerController::class, 'create'])
    ->name('seller.products.create');

});

require __DIR__.'/auth.php';
