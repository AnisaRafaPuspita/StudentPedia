<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        $stores = [
            ['nama_toko' => 'Elektronik Jaya', 'pemilik' => 'Budi Santoso'],
            ['nama_toko' => 'FashionKu Store', 'pemilik' => 'Dina Ayu'],
            ['nama_toko' => 'Cantika Beauty', 'pemilik' => 'Ratna Sari'],
            ['nama_toko' => 'Rumah Idaman Shop', 'pemilik' => 'Slamet Widodo'],
            ['nama_toko' => 'Sportify', 'pemilik' => 'Yoga Aditya'],
        ];

        // Ambil semua provinsi & kabupaten
        $provinces = DB::table('provinces')->pluck('kode')->toArray();
        $regenciesByProv = DB::table('regencies')->select('kode', 'province_kode')->get();

        for ($i = 1; $i <= 30; $i++) {

            // Random toko
            $store = $stores[array_rand($stores)];

            // Random provinsi
            $prov = $provinces[array_rand($provinces)];

            // Cari kabupaten yang sesuai provinsi
            $kabupatenList = $regenciesByProv->where('province_kode', $prov)->pluck('kode')->toArray();

            // fallback: kalau provinsi ini entah kenapa tidak ada kabupaten
            $kab = $kabupatenList[array_rand($kabupatenList)] ?? null;

            DB::table('sellers')->insert([
                'id'             => $i,
                'nama_toko'       => $store['nama_toko'] . " $i",
                'nama_pemilik'    => $store['pemilik'],
                'email'           => "seller{$i}_" . uniqid() . "@gmail.com",
                'no_hp'           => "0812345678$i",
                'alamat'          => "Alamat Penjual $i",
                'province_kode'   => $prov,
                'regency_kode'    => $kab,
                'status_verifikasi' => 'pending',
                'password'        => bcrypt('123456'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

        }
    }
}
