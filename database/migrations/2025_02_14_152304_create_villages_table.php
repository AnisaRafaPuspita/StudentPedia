<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('villages', function (Blueprint $table) {
            $table->string('kode', 20)->primary();
            $table->string('district_kode', 15);
            $table->string('nama', 100);
            $table->timestamps();

            $table->foreign('district_kode')
                ->references('kode')
                ->on('districts')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('villages');
    }
};
