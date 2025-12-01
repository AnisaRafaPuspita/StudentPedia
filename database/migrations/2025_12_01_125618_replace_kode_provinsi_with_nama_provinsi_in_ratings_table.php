<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            // hapus kolom kode_provinsi kalau ada
            if (Schema::hasColumn('ratings', 'kode_provinsi')) {
                $table->dropColumn('kode_provinsi');
            }

            // tambah kolom nama_provinsi
            $table->string('nama_provinsi')->nullable()->after('nomor_hp');
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn('nama_provinsi');
            $table->string('kode_provinsi')->nullable()->after('nomor_hp');
        });
    }
};
