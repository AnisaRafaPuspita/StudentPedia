<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {

            // kalau kolom ini belum ada
            if (!Schema::hasColumn('comments', 'product_id')) {
                $table->foreignId('product_id')
                      ->after('id')
                      ->constrained('products')
                      ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('comments', 'nama_pengunjung')) {
                $table->string('nama_pengunjung')->after('product_id');
            }

            if (!Schema::hasColumn('comments', 'komentar')) {
                $table->text('komentar')->after('nama_pengunjung');
            }

            if (!Schema::hasColumn('comments', 'rating')) {
                $table->unsignedTinyInteger('rating')->after('komentar');
            }

            // OPTIONAL: hapus kolom lama yang gak kepake
            // contoh kalau sebelumnya ada kolom name/phone/email:
            // $table->dropColumn(['name','phone','email']);
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // balikinnya susah kalau gak tau struktur awal,
            // jadi biasanya dikosongin aja
        });
    }
};
