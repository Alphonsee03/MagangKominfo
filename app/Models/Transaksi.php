<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'invoice',
        'user_id',
        'pelanggan_id',
        'tanggal',
        'total',
        'diskon',
        'bayar',
        'kembali',
        'metode_pembayaran'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total' => 'decimal:2',
        'bayar' => 'decimal:2',
        'kembali' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
