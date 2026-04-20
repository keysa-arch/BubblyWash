<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Service;

class Transaksi extends Model
{
    protected $fillable = [
        'customer_id',
        'service_id',
        'qty',
        'harga',
        'total',
        'diskon',
        'status',
        'tanggal'
    ];

    // Relasi ke tabel customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke tabel service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}