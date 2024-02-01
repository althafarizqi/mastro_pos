<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    // use SoftDeletes;
    use HasFactory, SoftDeletes;
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