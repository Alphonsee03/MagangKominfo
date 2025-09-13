<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_supplier', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('produk_id');
            $table->unsignedBigInteger('supplier_id');
            $table->timestamps();

            // Relasi
            $table->foreign('produk_id')
                  ->references('id')->on('produks')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('supplier_id')
                  ->references('id')->on('suppliers')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_supplier');
    }
};
