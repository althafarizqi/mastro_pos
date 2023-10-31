<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;
    protected $table = 'detail_pembelians';
    protected $fillable = [
        'id',
        'pembelian_id',
        'barang_id',
        'jumlah',
        'harga',
        'create_at'
    ];
}