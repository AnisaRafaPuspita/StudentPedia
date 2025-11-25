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
use App\Models\District;
use Illuminate\Support\Facades\DB; 



class RegisteredUserController extends Controller
{
    public function create(): View
    {
        // Ambil hanya provinsi di Pulau Jawa
        $provinces = Province::whereIn('id', [31, 32, 33, 34, 35, 36])
            ->orderBy('name')   // kalau nama kolom di tabel kamu "Name", ganti jadi 'Name'
            ->get();

        // Kita TIDAK perlu kirim $regencies lagi, karena akan di-load via AJAX
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
        'province_id'  => 'required|integer',
        'regency_id'   => 'required|integer',
        'district_id'  => 'required|exists:districts,id',

        // Dokumen
        'no_ktp_pic'  => 'required|string|max:20',
        'foto_pic'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'file_ktp_pic'=> 'nullable|mimes:jpg,jpeg,png,pdf|max:4096',
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
            'province_id'       => $request->province_id,
            'regency_id'        => $request->regency_id,
            'district_id'       => $request->district_id,
            'no_ktp_pic'        => $request->no_ktp_pic,
            'foto_pic'          => $foto_pic_path,
            'file_ktp_pic'      => $file_ktp_pic_path,
            'status_verifikasi' => 'pending',
        ]);

        DB::commit();

    } catch (\Throwable $e) {
        DB::rollBack();
        throw $e; // buat sementara biar kelihatan errornya kalau ada
    }

    // Event Laravel Breeze (kirim email verif email kalau pakai)
    event(new Registered($user));

    // ============================
    // 3. LOGIN USER
    // ============================
    Auth::login($user);

    // ============================
    // 4. REDIRECT KE HALAMAN PENDING
    // ============================
    return redirect()->route('seller.pending');
}


    public function getRegencies($province_id)
    {
        return Regency::where('province_id', $province_id)->get();
    }

    public function getDistricts($regency_id)
    {
        return District::where('regency_id', $regency_id)->get();
    }

}
