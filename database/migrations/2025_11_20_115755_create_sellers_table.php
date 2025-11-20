<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('nama_toko');
            $table->string('deskripsi_singkat')->nullable();

            // Data PIC
            $table->string('nama_pic');
            $table->string('no_hp');
            $table->string('email'); // Email PIC

            // Alamat lengkap
            $table->string('alamat_jalan');
            $table->string('rt');
            $table->string('rw');
            $table->string('kelurahan');
            $table->unsignedBigInteger('regency_id');
            $table->unsignedBigInteger('province_id');

            // Dokumen
            $table->string('no_ktp_pic');
            $table->string('foto_pic')->nullable();
            $table->string('file_ktp_pic')->nullable();

            // Status sistem
            $table->string('status_verifikasi')->default('pending'); // pending | approved | rejected

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
