<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianStok extends Model
{
    protected $fillable = [
        'supplier_id',
        'tanggal',
        'total'
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'total' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
{
    return $this->hasMany(DetailPembelian::class, 'pembelian_stok_id');
}
}

