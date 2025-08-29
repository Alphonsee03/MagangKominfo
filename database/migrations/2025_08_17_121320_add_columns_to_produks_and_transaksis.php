<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('stok');
            $table->string('foto')->nullable()->after('deskripsi');
        });

        Schema::table('transaksis', function (Blueprint $table) {
            $table->enum('metode_pembayaran', ['cash', 'qris'])->default('cash')->after('kembali');
            $table->enum('status', ['lunas', 'pending', 'dibatalkan'])->default('pending')->after('metode_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'foto']);
        });

        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'status']);
        });
    }
};
