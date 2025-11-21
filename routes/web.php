<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\catalog\CatalogController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Models\Regency;
use App\Http\Controllers\WilayahController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::get('/wilayah/provinsi', [WilayahController::class, 'provinsi']);
Route::get('/wilayah/kabupaten/{kode}', [WilayahController::class, 'kabupaten']);
Route::get('/wilayah/kecamatan/{kode}', [WilayahController::class, 'kecamatan']);
Route::get('/wilayah/kelurahan/{kode}', [WilayahController::class, 'kelurahan']);


Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('catalog.index');
})->middleware(['auth'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Catalog route
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
});

// Search routes
Route::get('/search', [SearchController::class, 'results'])->name('search');
Route::get('/search/results', [SearchController::class, 'results'])->name('search.results');



require __DIR__.'/auth.php';
