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
    Schema::create('provinces', function (Blueprint $table) {
        $table->string('kode', 2)->primary();
        $table->string('nama', 100);
    });

    Schema::create('regencies', function (Blueprint $table) {
        $table->string('kode', 5)->primary();
        $table->string('province_kode', 2);
        $table->string('nama', 100);
        $table->foreign('province_kode')->references('kode')->on('provinces');
    });

    Schema::create('districts', function (Blueprint $table) {
        $table->string('kode', 8)->primary();
        $table->string('regency_kode', 5);
        $table->string('nama', 100);
        $table->foreign('regency_kode')->references('kode')->on('regencies');
    });

    Schema::create('villages', function (Blueprint $table) {
        $table->string('kode', 13)->primary();
        $table->string('district_kode', 8);
        $table->string('nama', 100);
        $table->foreign('district_kode')->references('kode')->on('districts');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayah_tables');
    }
};
