<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->string('email')->nullable()->after('nama_pengunjung');
            $table->string('nomor_hp')->nullable()->after('email');
            $table->string('nama_provinsi')->nullable()->after('nomor_hp');
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn(['email', 'nomor_hp', 'nama_provinsi']);
        });
    }
};
