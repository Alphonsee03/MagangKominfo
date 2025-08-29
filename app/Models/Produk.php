<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produk extends Model
{
    protected $fillable = [
        'kategori_id',
        'kode_produk',
        'nama',
        'harga_beli',
        'harga_jual',
        'stok',
        'deskripsi',
        'foto',
    ];

    // Hapus kolom suppliers dari fillable karena sekarang menggunakan relasi

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }



    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'produk_supplier', 'produk_id', 'supplier_id');
    }

    public function detailPembelians()
    {
        return $this->hasMany(DetailPembelian::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'produk_id');
    }

}
