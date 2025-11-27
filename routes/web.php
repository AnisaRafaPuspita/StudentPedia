<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\SellerStatusController;
use App\Http\Controllers\PlatformSellerController;

use App\Http\Controllers\Catalog\CatalogController;
use App\Http\Controllers\Catalog\DetailProductController;

use App\Mail\SellerApprovedMail;
use App\Models\Seller;

// ========= ROUTE WILAYAH (dari temenmu) =========
Route::get('/wilayah/provinsi', [WilayahController::class, 'provinsi']);
Route::get('/wilayah/kabupaten/{kode}', [WilayahController::class, 'kabupaten']);
Route::get('/wilayah/kecamatan/{kode}', [WilayahController::class, 'kecamatan']);
Route::get('/wilayah/kelurahan/{kode}', [WilayahController::class, 'kelurahan']);

// ========= ROUTE PUBLIC CATALOG =========
Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/product/{id}', [DetailProductController::class, 'show'])->name('product.detailProduct');

// ========= DASHBOARD (SETELAH LOGIN) =========
Route::get('/dashboard', function () {
    $user = Auth::user();

    // Kalau platform → lempar ke halaman verifikasi seller
    if ($user->role === 'platform') {
        return redirect()->route('platform.sellers.index');
    }

    // Kalau seller → cek status verifikasi
    $seller = Seller::where('user_id', $user->id)->first();

    if ($seller) {
        if ($seller->status_verifikasi === 'pending') {
            return redirect()->route('seller.pending');
        }

        if ($seller->status_verifikasi === 'approved') {
            return redirect()->route('seller.dashboard');
        }

        if ($seller->status_verifikasi === 'rejected') {
            return redirect()->route('seller.pending')
                ->with('status', 'Pengajuan Anda ditolak.');
        }
    }

    // fallback kalau bukan seller dan bukan platform
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ========= ROUTE AUTH PROFIL =========
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// ========= ROUTE SELLER STATUS =========
Route::middleware(['auth'])->group(function () {
    Route::get('/seller/pending', [SellerStatusController::class, 'pending'])
        ->name('seller.pending');
});

// ========= ROUTE DASHBOARD SELLER =========
Route::middleware(['auth', 'role:seller'])->group(function() {
    Route::get('/seller/dashboard', function () {
        return view('seller.dashboard');
    })->name('seller.dashboard');
});

// ========= ROUTE PLATFORM (ADMIN) =========
Route::middleware(['auth', 'role:platform'])
    ->prefix('platform')
    ->name('platform.')
    ->group(function () {
        Route::get('/sellers', [PlatformSellerController::class, 'index'])
            ->name('sellers.index');

        Route::post('/sellers/{seller}/approve', [PlatformSellerController::class, 'approve'])
            ->name('sellers.approve');

        Route::post('/sellers/{seller}/reject', [PlatformSellerController::class, 'reject'])
            ->name('sellers.reject');
    });

// ========= ROUTE TEST EMAIL (opsional) =========
Route::get('/test-email', function () {
    $seller = \App\Models\Seller::latest()->first(); // ambil seller terakhir

    Mail::to($seller->email_pic)->send(new SellerApprovedMail($seller));

    return 'Email test dikirim ke ' . $seller->email_pic;
});

// ========= ROUTE LOKASI UNTUK FORM REGISTER (JSON) =========
// (nanti LocationController perlu disesuaikan ke kolom province_kode/regency_kode/district_kode)
Route::get('/get-regencies/{province_kode}', [LocationController::class, 'getRegencies']);
Route::get('/get-districts/{regency_kode}', [LocationController::class, 'getDistricts']);
Route::get('/get-villages/{district_kode}', [LocationController::class, 'getVillages']);

// ========= SEARCH ROUTE (dari main) =========
Route::get('/search', [SearchController::class, 'results'])->name('search');
Route::get('/search/results', [SearchController::class, 'results'])->name('search.results');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');


require __DIR__.'/auth.php';
