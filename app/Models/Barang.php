<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $primaryKey = 'kd_barang'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $fillable = ['kd_barang', 'nama_barang', 'stok'];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($barang) {
            $latestBarang = static::latest()->first();
    
            if (!$latestBarang) {
                $barang->kd_barang = 'BR001';
            } else {
                $latestKode = $latestBarang->kd_barang;
                $number = intval(substr($latestKode, 2)) + 1;
                $nextNumber = str_pad($number, 3, '0', STR_PAD_LEFT);
                $barang->kd_barang = 'BR' . $nextNumber;
            }
        });
    }
}
