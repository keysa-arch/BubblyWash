<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',          
        'nama_customer',
        'no_hp',
        'alamat'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    // customer milik 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // customer punya banyak transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    // customer punya 1 member
    public function member()
    {
        return $this->hasOne(Member::class);
    }
}