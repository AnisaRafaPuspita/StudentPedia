<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sudah tidak dipakai lagi karena schema sellers baru
        // sudah menggunakan province_kode, regency_kode, district_kode.
    }

    public function down(): void
    {
        //
    }
};
