<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tidak digunakan lagi.
        // Tabel 'villages' sudah dibuat oleh 2025_02_14_152304_create_villages_table
        // dengan struktur kode Kemendagri (kode, district_kode, nama).
    }

    public function down(): void
    {
        //
    }
};
