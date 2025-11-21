<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;


class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $provinces = \App\Models\Province::all();
        $regencies = \App\Models\Regency::all();

        return view('auth.register', [
            'provinces' => Province::all(),
            'regencies' => Regency::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // ============================
        // VALIDASI FORM REGISTRASI
        // ============================
        //dd("STORE MASUK", $request->all());
        $request->validate([
            // User account
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Seller info
            'nama_toko' => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string',

            'nama_pic' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email_pic' => 'required|email|max:255',

            // Alamat
            'alamat_jalan' => 'required|string|max:255',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
            'kelurahan' => 'required|string|max:255',
            'province_id' => 'required|integer',
            'regency_id' => 'required|integer',

            // Dokumen
            'no_ktp_pic' => 'required|string|max:20',
            'foto_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_ktp_pic' => 'nullable|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        // ============================
        // 1. CREATE USER
        // ============================
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, // email untuk login
            'password' => Hash::make($request->password),
            //'role' => 'seller', // beri role seller
        ]);

        // Event Laravel Breeze
        event(new Registered($user));

        // ============================
        // 2. HANDLE FILE UPLOAD
        // ============================
        $foto_pic_path = null;
        $file_ktp_pic_path = null;

        if ($request->hasFile('foto_pic')) {
            $foto_pic_path = $request->file('foto_pic')->store('seller/foto', 'public');
        }

        if ($request->hasFile('file_ktp_pic')) {
            $file_ktp_pic_path = $request->file('file_ktp_pic')->store('seller/ktp', 'public');
        }

        // ============================
        // 3. CREATE SELLER DATA
        // ============================
        $seller = Seller::create([
            
            'user_id' => $user->id,

            'nama_toko' => $request->nama_toko,
            'deskripsi_singkat' => $request->deskripsi_singkat,

            'nama_pic' => $request->nama_pic,
            'email_pic' => $request->email_pic, // email PIC
            'no_hp' => $request->no_hp,

            'alamat_jalan' => $request->alamat_jalan,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kelurahan' => $request->kelurahan,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,

            'no_ktp_pic' => $request->no_ktp_pic,
            'foto_pic' => $foto_pic_path,
            'file_ktp_pic' => $file_ktp_pic_path,

            'status_verifikasi' => 'pending',
        ]);
        dd("SELLER CREATED?", $seller);


        // ============================
        // 4. LOGIN USER
        // ============================
        Auth::login($user);

        // ============================
        // 5. REDIRECT SELLER DASHBOARD
        // ============================
        //return redirect()->route('seller.dashboard');
        return redirect(RouteServiceProvider::HOME);
    }
}
