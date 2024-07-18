<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';
    protected $primaryKey = 'id_jual';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_jual', 'tanggal_jual', 'total_jual', 'bayar', 'kembali'];

    public function detailJual()
    {
        return $this->hasMany(DetailJual::class, 'id_jual', 'id_jual');
    }

    public function terimaKas()
    {
        return $this->hasMany(PenerimaanKas::class, 'id_jual', 'id_jual');
    }





    // public function detailJual()
    // {
    //     return $this->hasMany(DetailJual::class, 'id_jual', 'id_jual');
    // }
    public static function boot()
    {
        parent::boot();

        // Menghapus detail jual yang terkait saat penjualan dihapus
        static::deleting(function($penjualan) {
            $penjualan->detailJual()->delete();
            $penjualan->terimaKas()->delete();
        });
    }
}
