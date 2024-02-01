<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPenjualan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'tanggal',
        'nota_penjualan',
        'pelanggan_id',
        'pembayaran',
        'tanggal_japo',
        'pajak',
        'diskon',
        'total_harga'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
}