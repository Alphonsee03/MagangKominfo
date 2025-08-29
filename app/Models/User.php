<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama', 'username', 'email', 'password', 'role', 'remember_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];



    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }
}

