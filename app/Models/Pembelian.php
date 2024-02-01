<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelians';
    protected $fillable = [
        'id',
        'tanggal',
        'nota_beli',
        'suplier_id',
        'pembayaran',
        'tanggal_japo',
        'total_harga',
        'create_at'
    ];

    // public function barang()
    // {
    //     return $this->belongsTo(Barang::class, 'barang_id', 'id');
    // }
    public function suplier()
    {
        return $this->belongsTo(Suplier::class, 'suplier_id', 'id');
    }
    public function hutang()
    {
        return $this->belongsTo(Hutang::class, 'id', 'pembelian_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
}