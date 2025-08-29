<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $fillable = ['pembelian_stok_id', 'produk_id', 'jumlah', 'harga_beli', 'subtotal'];

    public function pembelianStok()
    {
        return $this->belongsTo(PembelianStok::class, 'pembelian_stok_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }



}

