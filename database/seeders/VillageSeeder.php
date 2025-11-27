<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillageSeeder extends Seeder
{
    public function run(): void
    {
        $data = file(database_path('wilayah/wilayah.sql'));

        foreach ($data as $line) {
            if (preg_match("/INSERT INTO wilayah/", $line)) {
                preg_match_all("/\('([^']+)',\s*'([^']+)'\)/", $line, $matches);

                foreach ($matches[1] as $i => $kode) {
                    if (substr_count($kode, '.') === 3) { // level 4 = kelurahan/desa
                        DB::table('villages')->insert([
                            'kode' => $kode,
                            'district_kode' => implode('.', array_slice(explode('.', $kode), 0, 3)),
                            'nama' => $matches[2][$i]
                        ]);
                    }
                }
            }
        }
    }
}
