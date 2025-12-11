<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            // opsi jenis variasi: warna / ukuran_sepatu / ukuran_baju
            $table->enum('type', ['warna', 'ukuran_sepatu', 'ukuran_baju']);
            // isi manual 
            $table->string('value');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};

