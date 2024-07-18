<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJual extends Model
{
    use HasFactory;

    protected $table = 'detail_jual';
    protected $primaryKey = 'id';
    protected $fillable = ['id_jual', 'kd_barang', 'jumlah', 'harga', 'subtotal'];

    public function barang()
{
    return $this->belongsTo(Barang::class, 'kd_barang', 'kd_barang');
}


    public function jual()
    {
        return $this->belongsTo(Penjualan::class, 'id_jual', 'id_jual');
    }


}


// In DetailJual model

