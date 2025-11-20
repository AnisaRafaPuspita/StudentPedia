<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {

            $table->text('deskripsi_singkat')->nullable();
            $table->string('nama_pic')->nullable();

            // Alamat detail
            $table->string('alamat_jalan')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('kelurahan')->nullable();

            // Identitas
            $table->string('no_ktp_pic')->nullable();
            $table->string('foto_pic')->nullable();
            $table->string('file_ktp_pic')->nullable();

            // status verifikasi -> gunakan field yang sudah ada
            if (!Schema::hasColumn('sellers', 'status_verifikasi')) {
                $table->string('status_verifikasi')->default('pending');
            }
            //$table->string('status_verifikasi')->default('pending')->change();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
