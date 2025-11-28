<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        // baca file SQL wilayah
        $sqlPath = database_path('wilayah/wilayah.sql');

        if (File::exists($sqlPath)) {
            DB::unprepared(File::get($sqlPath));
        }
    }
}