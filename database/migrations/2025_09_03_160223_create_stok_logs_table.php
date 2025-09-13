<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('produk_id');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->integer('jumlah');
            $table->string('keterangan', 255)->nullable();
            $table->unsignedBigInteger('transaksi_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // Relasi
            $table->foreign('produk_id')
                  ->references('id')->on('produks')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('transaksi_id')
                  ->references('id')->on('transaksis')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_logs');
    }
};
