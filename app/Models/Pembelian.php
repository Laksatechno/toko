<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';
    protected $primaryKey = 'id_beli';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_beli', 
        'tanggal_beli', 
        'total_beli', 
        'kd_supplier', 
        'bayar', 
        'kembali'
    ];

    public function detailBeli()
    {
        return $this->hasMany(DetailBeli::class, 'id_beli', 'id_beli');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kd_supplier', 'kd_supplier');
    }

    public function keluarKas()
    {
        return $this->hasMany(PengeluaranKas::class, 'id_keluarkas', 'id_keluarkas');
    }

    public static function boot()
    {
        parent::boot();

        // Menghapus detail beli yang terkait saat pembelian dihapus
        static::deleting(function($pembelian) {
            $pembelian->detailBeli()->delete();
            $pembelian->keluarKas()->delete();
        });
    }
}
