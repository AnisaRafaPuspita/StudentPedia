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

            $table->string('nama_toko');
            $table->string('nama_pemilik');
            $table->string('email')->unique();
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();

            // FIX: pakai kode Kemendagri, bukan id integer
            $table->string('province_kode', 10)->nullable();
            $table->string('regency_kode', 10)->nullable();

            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])
                  ->default('pending');

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
