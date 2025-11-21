<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('seller_id');
        $table->unsignedBigInteger('category_id')->nullable();

        $table->string('nama_produk');
        $table->text('deskripsi')->nullable();
        $table->integer('harga');
        $table->integer('stok');
        $table->string('gambar')->nullable();

        $table->timestamps();

        // Foreign keys
        $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
    });
}
};