<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('detail_pembelians', function (Blueprint $table) {
            $table->foreignId('supplier_produk_id')->after('pembelian_stok_id')->nullable()->constrained('supplier_produks')->cascadeOnDelete();
            $table->foreignId('produk_id')->nullable()->change(); // biar bisa null dulu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_pembelians', function (Blueprint $table) {
            $table->dropForeign(['supplier_produk_id']);
            $table->dropColumn('supplier_produk_id');
        });
    }
};
