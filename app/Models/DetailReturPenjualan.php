<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReturPenjualan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'penjualan_id',
        'barang_id',
        'jumlah',
        'harga_satuan',
        'subtotal_harga',
        'create_at'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
}