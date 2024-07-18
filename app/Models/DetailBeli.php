<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBeli extends Model
{
    use HasFactory;
    protected $table = 'detail_beli';
    protected $primaryKey = 'id_detbeli';
    protected $fillable  = ['id_detbeli', 'id_beli', 'kd_barang', 'jumlah', 'harga', 'subtotal' ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kd_barang', 'kd_barang');
    }

    public function beli()
    {
        return $this->belongsTo(Pembelian::class, 'id_beli', 'id_beli');
    }
}
