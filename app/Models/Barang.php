<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';

    protected $fillable = [
        'kategori_id',
        'nama',
        'harga',
        'stok',
        'create_at'
    ];

    public function kategoribarang()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id', 'id');
    }

    
    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }
}