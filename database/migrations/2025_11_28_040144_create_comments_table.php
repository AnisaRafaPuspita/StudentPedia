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
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        $table->foreignId('rating_id')->nullable()->constrained('ratings')->onDelete('cascade');
        $table->string('nama_pengunjung');
        $table->text('komentar');
        $table->unsignedTinyInteger('rating'); // 1-5
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
