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

            // hapus titik biar kodenya jadi angka semua
            $kode = str_replace('.', '', $w->kode);
            $len  = strlen($kode);

            if ($len === 2) {
                DB::table('provinces')->updateOrInsert(
                    ['kode' => $kode],
                    ['nama' => $w->nama]
                );

            } elseif ($len === 4) {
                DB::table('regencies')->updateOrInsert(
                    ['kode' => $kode],
                    [
                        'province_kode' => substr($kode, 0, 2),
                        'nama'          => $w->nama,
                    ]
                );

            } elseif ($len === 6) {
                DB::table('districts')->updateOrInsert(
                    ['kode' => $kode],
                    [
                        'regency_kode' => substr($kode, 0, 4),
                        'nama'         => $w->nama,
                    ]
                );

            } elseif ($len === 10) {
                DB::table('villages')->updateOrInsert(
                    ['kode' => $kode],
                    [
                        'district_kode' => substr($kode, 0, 6),
                        'nama'          => $w->nama,
                    ]
                );
            }
        }

    }
}
