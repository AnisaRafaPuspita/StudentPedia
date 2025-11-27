<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->string('kode', 15)->primary();
            $table->string('regency_kode', 13);
            $table->string('nama', 100);
            $table->timestamps();

            $table->foreign('regency_kode')
                ->references('kode')
                ->on('regencies')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
