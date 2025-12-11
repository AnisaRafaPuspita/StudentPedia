<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('rating_id')->nullable();
            $table->foreign('rating_id')->references('id')->on('ratings')->onDelete('cascade');

            $table->string('nama_pengunjung');
            $table->text('komentar');

            $table->timestamps();

            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
