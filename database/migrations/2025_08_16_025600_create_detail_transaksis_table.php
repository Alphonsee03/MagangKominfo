<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('produk_id');
            $table->unsignedInteger('jumlah');
            $table->decimal('harga_jual', 10, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            // Relasi
            $table->foreign('transaksi_id')
                  ->references('id')->on('transaksis')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('produk_id')
                  ->references('id')->on('produks')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
