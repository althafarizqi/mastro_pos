<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualans';
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

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'id');
    }
}