<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        // Ambil hanya provinsi di Pulau Jawa (kode: 31–36) dari tabel provinces (kode, nama)
        $provinces = Province::select('kode', 'nama')->orderBy('nama')->get();


        // Regency & district nanti di-load via AJAX, jadi cukup kirim provinces
        return view('auth.register', compact('provinces'));
    }

    public function store(Request $request): RedirectResponse
    {
        // ============================
        // VALIDASI FORM REGISTRASI
        // ============================
        $request->validate([
            // User account
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Seller info
            'nama_toko'         => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string',

            'nama_pic'  => 'required|string|max:255',
            'no_hp'     => 'required|string|max:20',
            'email_pic' => 'required|email|max:255',

            // Alamat
            'alamat_jalan' => 'required|string|max:255',
            'rt'           => 'required|string|max:10',
            'rw'           => 'required|string|max:10',
            'kelurahan'    => 'required|string|max:255',

            // Wilayah (pakai kode, sesuai schema main)
            'province_kode' => 'required|exists:provinces,kode',
            'regency_kode'  => 'required|exists:regencies,kode',
            'district_kode' => 'required|exists:districts,kode',

            // Dokumen
            'no_ktp_pic'   => 'required|string|max:20',
            'foto_pic'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_ktp_pic' => 'nullable|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        // ============================
        // 1. HANDLE FILE UPLOAD
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
        // 2. TRANSACTION: BUAT USER + SELLER
        // ============================
        DB::beginTransaction();

        try {
            // Buat user
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Buat seller
            $seller = Seller::create([
                'user_id'           => $user->id,
                'nama_toko'         => $request->nama_toko,
                'deskripsi_singkat' => $request->deskripsi_singkat,
                'nama_pic'          => $request->nama_pic,
                'email_pic'         => $request->email_pic,
                'no_hp'             => $request->no_hp,

                'alamat_jalan'      => $request->alamat_jalan,
                'rt'                => $request->rt,
                'rw'                => $request->rw,
                'kelurahan'         => $request->kelurahan,

                // Wilayah: pakai kode, sesuai schema tabel sellers yang baru
                'province_kode'     => $request->province_kode,
                'regency_kode'      => $request->regency_kode,
                'district_kode'     => $request->district_kode,

                'no_ktp_pic'        => $request->no_ktp_pic,
                'foto_pic'          => $foto_pic_path,
                'file_ktp_pic'      => $file_ktp_pic_path,

                'status_verifikasi' => 'pending',
            ]);

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e; // sementara untuk debugging
        }

        event(new Registered($user));

        // Login user
        Auth::login($user);

        // Redirect ke halaman pending
        return redirect()->route('seller.pending');
    }

    // Kalau route AJAX-mu masih pakai controller ini, sesuaikan juga ke kode:
    public function getRegencies($province_kode)
    {
        return Regency::where('province_kode', $province_kode)
            ->orderBy('nama')
            ->get();
    }

    public function getDistricts($regency_kode)
    {
        return District::where('regency_kode', $regency_kode)
            ->orderBy('nama')
            ->get();
    }
}
