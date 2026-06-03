<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;

class RegisteredUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registrasi_seller_berhasil_dengan_semua_field_valid()
    {
        Storage::fake('public');

        // Siapkan data wilayah (wajib ada karena divalidasi exists:)
        Province::create(['kode' => '35', 'nama' => 'Jawa Timur']);
        Regency::create(['kode' => '3501', 'province_kode' => '35', 'nama' => 'Lamongan']);
        District::create(['kode' => '350101', 'regency_kode' => '3501', 'nama' => 'Lamongan']);

        $response = $this->post('/register', [
            'name'                  => 'Budi Santoso',
            'email'                 => 'budi@example.com',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',

            'nama_toko'         => 'Toko Budi',
            'deskripsi_singkat' => 'Toko alat tulis terlengkap',
            'nama_pic'          => 'Budi',
            'no_hp'             => '081234567890',
            'email_pic'         => 'pic@example.com',

            'alamat_jalan'  => 'Jl. Mawar No. 1',
            'rt'            => '001',
            'rw'            => '002',
            'kelurahan'     => 'Sidoharjo',
            'province_kode' => '35',
            'regency_kode'  => '3501',
            'district_kode' => '350101',

            'no_ktp_pic'   => '3512345678901234',
            'foto_pic'     => UploadedFile::fake()->image('foto.jpg'),
            'file_ktp_pic' => UploadedFile::fake()->image('ktp.jpg'),
        ]);

        // Redirect ke halaman pending setelah registrasi
        $response->assertRedirect(route('seller.pending'));

        // Data tersimpan di database
        $this->assertDatabaseHas('users', ['email' => 'budi@example.com']);
        $this->assertDatabaseHas('sellers', [
            'nama_toko'         => 'Toko Budi',
            'status_verifikasi' => 'pending',
        ]);
    }
}