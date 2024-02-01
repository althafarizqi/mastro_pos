<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPenjualan extends Model
{
    // use SoftDeletes;
    use HasFactory, SoftDeletes;
    protected $table = 'detail_penjualans';
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