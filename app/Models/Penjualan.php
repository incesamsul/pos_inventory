<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $guarded = ['id_penjualan'];

    public function barang()
    {
        return $this->hasOne(Barang::class, 'kode_barang', 'kode_barang');
    }
}
