<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductReviewController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WilayahController;

// catalog kamu
use App\Http\Controllers\Catalog\CatalogController;
use App\Http\Controllers\Catalog\DetailProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========= ROUTE WILAYAH (dari temenmu) =========
Route::get('/wilayah/provinsi', [WilayahController::class, 'provinsi']);
Route::get('/wilayah/kabupaten/{kode}', [WilayahController::class, 'kabupaten']);
Route::get('/wilayah/kecamatan/{kode}', [WilayahController::class, 'kecamatan']);
Route::get('/wilayah/kelurahan/{kode}', [WilayahController::class, 'kelurahan']);


// ========= ROUTE PUBLIC CATALOG (punyamu) =========
Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/product/{id}', [DetailProductController::class, 'show'])->name('product.detailProduct');


// ========= DASHBOARD (login dulu) =========
Route::get('/dashboard', function () {
    return view('catalog.index');
})->middleware(['auth'])->name('dashboard');


// ========= ROUTE AUTH USER =========
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


// ========= SEARCH ROUTE =========
Route::get('/search', [SearchController::class, 'results'])->name('search');
Route::get('/search/results', [SearchController::class, 'results'])->name('search.results');

// ========= Imageproduct ROUTE =========
Route::get('/product/{id}', [DetailProductController::class, 'show'])
    ->name('product.detailProduct');


Route::get('/produk/{product}/komentar', [ProductReviewController::class, 'create'])
    ->name('reviews.create');

Route::post('/produk/{product}/komentar', [ProductReviewController::class, 'store'])
    ->name('reviews.store');

Route::get('/produk/{product}/komentar/sukses', [ProductReviewController::class, 'thanks'])
    ->name('reviews.thanks');

require __DIR__.'/auth.php';
