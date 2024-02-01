<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory;
    protected $table = 'kategori_barangs';
    protected $fillable = [
        'id',
        'nama',
        'created_at'
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}