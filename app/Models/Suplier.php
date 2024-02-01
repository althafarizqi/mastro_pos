<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    use HasFactory;
    protected $table = 'supliers';

    protected $fillable = [
        'id',
        'nama',
        'alamat',
        'telepon',
        'create_at'
    ];

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }
}