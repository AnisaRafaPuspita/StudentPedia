<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void{
        $this->call([
        // 1) seed wilayah dulu biar provinces/regencies/districts/villages keisi
            WilayahSeeder::class,
            WilayahSplitSeeder::class,
            // ProvinceSeeder::class,
            // RegencySeeder::class,
            // DistrictSeeder::class,
            // VillageSeeder::class,

            // 2) baru kategori, seller, product
            CategorySeeder::class,
            SellerSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
