<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Auth\SellerRegisteredUserController;
use App\Models\Regency;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Auth\RegisteredUserController;



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

Route::middleware(['auth', 'role:seller'])->group(function() {
    Route::get('/seller/dashboard', function () {
        return view('seller.dashboard');
    })->name('seller.dashboard');
});

//Route::get('/get-regencies/{province_id}', [RegisteredUserController::class, 'getRegencies']);
//Route::get('/get-districts/{regency_id}', [RegisteredUserController::class, 'getDistricts']);



//Route::get('/seller/register', [SellerRegisteredUserController::class, 'create'])
    //->name('seller.register');

    

/*Route::get('/get-regencies/{province_id}', function ($province_id) {
    return Regency::where('province_id', $province_id)->get();
});

Route::get('/regencies/{province_id}', function ($province_id) {
    return \App\Models\Regency::where('province_id', $province_id)->get();
});*/


Route::get('/get-regencies/{province_id}', [LocationController::class, 'getRegencies']);
Route::get('/get-districts/{regency_id}', [LocationController::class, 'getDistricts']);

//Route::get('/get-districts/{regency_id}', [RegisteredUserController::class, 'getDistricts']);





require __DIR__.'/auth.php';
