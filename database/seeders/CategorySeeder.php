<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama' => 'Elektronik'],
            ['nama' => 'Fashion'],
            ['nama' => 'Kecantikan'],
            ['nama' => 'Rumah Tangga'],
            ['nama' => 'Olahraga'],
        ];

        DB::table('categories')->insert($categories);
    }
}
