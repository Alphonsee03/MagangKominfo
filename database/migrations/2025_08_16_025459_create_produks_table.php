<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kategori_id');
            $table->string('kode_produk', 15);
            $table->string('nama', 255);
            $table->decimal('harga_beli', 10, 2);
            $table->decimal('harga_jual', 15, 2)->nullable();
            $table->unsignedInteger('stok')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('foto', 255)->nullable();
            $table->timestamps();

            // Constraints
            $table->foreign('kategori_id')
                ->references('id')->on('kategoris')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
