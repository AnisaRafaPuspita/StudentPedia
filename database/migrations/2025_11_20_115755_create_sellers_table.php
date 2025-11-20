<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('sellers', function (Blueprint $table) {
        $table->id();

        $table->string('nama_toko');
        $table->string('nama_pemilik');
        $table->string('email')->unique();
        $table->string('no_hp')->nullable();
        $table->text('alamat')->nullable();
        $table->unsignedBigInteger('province_id')->nullable();
        $table->unsignedBigInteger('regency_id')->nullable();
        $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending');
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->timestamps();

        
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
