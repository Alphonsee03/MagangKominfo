<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            // Drop index lama langsung (pakai nama index)
            $table->dropUnique('produks_kode_produk_unique');

            // Ubah panjang kolom + kasih unique lagi
            $table->string('kode_produk', 8)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->string('kode_produk', 50)->unique()->change();
        });
    }
};
