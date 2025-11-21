<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 30; $i++) {
            DB::table('sellers')->insert([
                'nama_toko'       => "Toko Penjual $i",
                'nama_pemilik'    => "Pemilik $i",
                'email' => "seller{$i}_" . uniqid() . "@gmail.com",
                'no_hp'           => "0812345678$i",
                'alamat'          => "Alamat Penjual $i",
                'province_id'     => 1,
                'regency_id'      => 1,
                'status_verifikasi' => 'pending', // ← FIX!
                'password'        => bcrypt('123456'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

        }
    }
}
