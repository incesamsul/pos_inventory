<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    use HasFactory;
    protected $table = 'retur';
    protected $guarded = ['id_retur'];

    public function barang()
    {
        return $this->hasOne(Barang::class, 'kode_barang', 'kode_barang');
    }
}
