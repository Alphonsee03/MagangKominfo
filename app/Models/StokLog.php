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
}
