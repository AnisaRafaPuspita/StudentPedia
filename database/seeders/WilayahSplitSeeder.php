<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSplitSeeder extends Seeder
{
    public function run(): void
    {
        $wilayah = DB::table('wilayah')->orderBy('kode')->get();

        foreach ($wilayah as $w) {
            $len = strlen($w->kode);

            if ($len === 2) {
                DB::table('provinces')->updateOrInsert(
                    ['kode' => $w->kode],
                    ['nama' => $w->nama]
                );
            } elseif ($len === 5) {
                DB::table('regencies')->updateOrInsert(
                    ['kode' => $w->kode],
                    [
                        'province_kode' => substr($w->kode, 0, 2),
                        'nama'          => $w->nama,
                    ]
                );
            } elseif ($len === 8) {
                DB::table('districts')->updateOrInsert(
                    ['kode' => $w->kode],
                    [
                        'regency_kode' => substr($w->kode, 0, 5),
                        'nama'         => $w->nama,
                    ]
                );
            } elseif ($len === 13) {
                DB::table('villages')->updateOrInsert(
                    ['kode' => $w->kode],
                    [
                        'district_kode' => substr($w->kode, 0, 8),
                        'nama'          => $w->nama,
                    ]
                );
            }
        }
    }
}
