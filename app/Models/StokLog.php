<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokLog extends Model
{
    protected $fillable = [
        'produk_id',
        'tipe',
        'jumlah',
        'keterangan',
        'transaksi_id',
        'user_id',
    ];

    // Helper opsional biar pemakaian konsisten
    public static function catat($produkId, $tipe, $jumlah, $keterangan = null, $transaksiId = null, $userId = null)
    {
        return static::create([
            'produk_id'     => $produkId,
            'tipe'          => $tipe,                 // 'masuk' | 'keluar'
            'jumlah'        => (int) abs($jumlah),    // selalu positif di kolom
            'keterangan'    => $keterangan,
            'transaksi_id'  => $transaksiId,
            'user_id'       => $userId,
        ]);
    }
        public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // (opsional) kalau mau tau siapa user yang melakukan log
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // (opsional) kalau mau tau transaksi terkait
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
