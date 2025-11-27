<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        $data = file(database_path('wilayah/wilayah.sql'));

        foreach ($data as $line) {
            if (preg_match("/INSERT INTO wilayah/", $line)) {
                preg_match_all("/\('([^']+)',\s*'([^']+)'\)/", $line, $matches);

                foreach ($matches[1] as $i => $kode) {
                    if (substr_count($kode, '.') === 0) { // level 1 = provinsi
                        DB::table('provinces')->insert([
                            'kode' => $kode,
                            'nama' => $matches[2][$i]
                        ]);
                    }
                }
            }
        }
    }
}
