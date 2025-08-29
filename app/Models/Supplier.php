<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model

{
    use HasFactory;
    protected $fillable = ['nama', 'telepon', 'alamat'];



    public function produks(): BelongsToMany
    {
        return $this->belongsToMany(Produk::class, 'produk_supplier', 'supplier_id', 'produk_id');
    }
}






