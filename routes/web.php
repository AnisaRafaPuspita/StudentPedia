<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\ProductReviewController;


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\DashboardSellerController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\SellerStatusController;
use App\Http\Controllers\PlatformSellerController;
use App\Http\Controllers\Catalog\CatalogController;
use App\Http\Controllers\Catalog\DetailProductController;
use App\Http\Controllers\DashboardPlatformController;

use App\Mail\SellerApprovedMail;
use App\Models\Seller;

/*
|--------------------------------------------------------------------------
| ROUTE WILAYAH (dari temenmu)
|--------------------------------------------------------------------------
*/

Route::get('/wilayah/provinsi', [WilayahController::class, 'provinsi']);
Route::get('/wilayah/kabupaten/{kode}', [WilayahController::class, 'kabupaten']);
Route::get('/wilayah/kecamatan/{kode}', [WilayahController::class, 'kecamatan']);
Route::get('/wilayah/kelurahan/{kode}', [WilayahController::class, 'kelurahan']);

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIC CATALOG
|--------------------------------------------------------------------------
*/
Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/product/{id}', [DetailProductController::class, 'show'])->name('product.detailProduct');

/*
|--------------------------------------------------------------------------
| DASHBOARD (SETELAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = Auth::user();

    // Kalau platform → lempar ke halaman verifikasi seller
    if ($user->role === 'platform') {
        return redirect()->route('platform.dashboard');
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

/*
|--------------------------------------------------------------------------
| ROUTE AUTH PROFIL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/platform/export/keaktifan', 
        [DashboardPlatformController::class, 'exportKeaktifan']
    )->name('platform.export.keaktifan');

    Route::get('/platform/export/kategori', 
        [DashboardPlatformController::class, 'exportKategori']
    )->name('platform.export.kategori');

    Route::get('/platform/export/provinsi', 
        [DashboardPlatformController::class, 'exportProvinsi']
    )->name('platform.export.provinsi');

    Route::get('/platform/export/rating', 
        [DashboardPlatformController::class, 'exportRating']
    )->name('platform.export.rating');

});

/*
|--------------------------------------------------------------------------
| SELLER STATUS (PENDING PAGE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/seller/pending', [SellerStatusController::class, 'pending'])
        ->name('seller.pending');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD + CRUD PENJUAL (SELLER) – pakai DashboardSellerController
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:seller'])->group(function () {

    // dashboard utama penjual
    Route::get('/seller/dashboard', [DashboardSellerController::class, 'index'])
        ->name('seller.dashboard');

    // alias URL lain (kalau mau dipakai)
    Route::get('/dashboardPenjual', [DashboardSellerController::class, 'index'])
        ->name('seller.dashboardPenjual');

    // CRUD produk
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

/*
|--------------------------------------------------------------------------
| ROUTE PLATFORM (ADMIN / PLATFORM)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:platform'])
    ->prefix('platform')
    ->name('platform.')
    ->group(function () {
        Route::get('/dashboard', [DashboardPlatformController::class, 'index'])
            ->name('dashboard');
        Route::get('/sellers', [PlatformSellerController::class, 'index'])
            ->name('sellers.index');

        Route::post('/sellers/{seller}/approve', [PlatformSellerController::class, 'approve'])
            ->name('sellers.approve');

        Route::post('/sellers/{seller}/reject', [PlatformSellerController::class, 'reject'])
            ->name('sellers.reject');
    });

/*
|--------------------------------------------------------------------------
| ROUTE TEST EMAIL (opsional)
|--------------------------------------------------------------------------
*/
Route::get('/test-email', function () {
    $seller = \App\Models\Seller::latest()->first(); // ambil seller terakhir

    Mail::to($seller->email_pic)->send(new SellerApprovedMail($seller));

    return 'Email test dikirim ke ' . $seller->email_pic;
});

/*
|--------------------------------------------------------------------------
| ROUTE LOKASI UNTUK FORM REGISTER (JSON)
|--------------------------------------------------------------------------
*/
Route::get('/get-regencies/{province_kode}', [LocationController::class, 'getRegencies']);
Route::get('/get-districts/{regency_kode}', [LocationController::class, 'getDistricts']);
Route::get('/get-villages/{district_kode}', [LocationController::class, 'getVillages']);

/*
|--------------------------------------------------------------------------
| SEARCH ROUTE
|--------------------------------------------------------------------------
*/
Route::get('/search', [SearchController::class, 'results'])->name('search');
Route::get('/search/results', [SearchController::class, 'results'])->name('search.results');

/*
|--------------------------------------------------------------------------
| WELCOME PAGE (kalau mau dipakai terpisah)
|--------------------------------------------------------------------------
*/
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');


// ========= REVIEW ROUTE =========
Route::post('product/{product}/visitor', [ProductReviewController::class, 'storeVisitor'])
    ->name('visitor.store');

Route::get('/produk/{product}/komentar', [ProductReviewController::class, 'create'])
    ->name('reviews.create');

Route::post('/produk/{product}/komentar', [ProductReviewController::class, 'store'])
    ->name('reviews.store');

Route::get('/produk/{product}/komentar/sukses', [ProductReviewController::class, 'thanks'])
    ->name('reviews.thanks');

/*Route::get('/test-email', function () {
    \Illuminate\Support\Facades\Mail::raw('Tes email StudentPedia', function($m){
        $m->to('emailkamu@gmail.com')->subject('Tes Email');
    });

    return 'sent';
});*/

Route::get('/seller/dashboard/pdf/{type}',
    [DashboardSellerController::class, 'downloadPdf']
)->name('seller.grafik.pdf');



/*
|--------------------------------------------------------------------------
| AUTH ROUTES (login, register, dll)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';