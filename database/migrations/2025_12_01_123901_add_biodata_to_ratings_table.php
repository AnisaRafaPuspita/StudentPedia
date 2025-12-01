<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->string('email', 100)->nullable()->after('nama_pengunjung');
            $table->string('nomor_hp', 20)->nullable()->after('email');
            $table->string('kode_provinsi', 20)->nullable()->after('nomor_hp');
        });
    }

    public function down()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn(['email','nomor_hp','kode_provinsi']);
        });
    }

};
