<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegencySeeder extends Seeder
{
    public function run(): void
    {
        $data = file(database_path('wilayah/wilayah.sql'));

        foreach ($data as $line) {
            if (preg_match("/INSERT INTO wilayah/", $line)) {
                preg_match_all("/\('([^']+)',\s*'([^']+)'\)/", $line, $matches);

                foreach ($matches[1] as $i => $kode) {
                    if (substr_count($kode, '.') === 1) { // level 2 = kab/kota
                        DB::table('regencies')->insert([
                            'kode' => $kode,
                            'province_kode' => explode('.', $kode)[0],
                            'nama' => $matches[2][$i]
                        ]);
                    }
                }
            }
        }
    }
}
