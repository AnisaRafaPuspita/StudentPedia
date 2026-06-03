<?php

namespace Database\Factories;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

class SellerFactory extends Factory
{
    protected $model = Seller::class;

    public function definition(): array
    {
        return [
            'user_id'           => null, // diisi saat test: Seller::factory()->create(['user_id' => $user->id])
            'nama_toko'         => $this->faker->company(),
            'deskripsi_singkat' => $this->faker->sentence(),
            'nama_pic'          => $this->faker->name(),
            'email_pic'         => $this->faker->unique()->safeEmail(),
            'no_hp'             => '08' . $this->faker->numerify('#########'),
            'alamat_jalan'      => $this->faker->streetAddress(),
            'rt'                => '001',
            'rw'                => '002',
            'kelurahan'         => $this->faker->city(),
            'province_kode'     => '35',
            'regency_kode'      => '3501',
            'district_kode'     => '350101',
            'no_ktp_pic'        => $this->faker->numerify('################'),
            'foto_pic'          => null,
            'file_ktp_pic'      => null,
            'status_verifikasi' => 'pending',
        ];
    }
}