<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranKas extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran_kas';
    protected $primaryKey = 'id_keluarkas';
    public $incrementing = false;
    protected $fillable = ['id_keluarkas', 'id_beli', 'id_biaya', 'keterangan', 'tanggal_transaksi', 'jumlah'];

    public function beli()
    {
        return $this->belongsTo(Pembelian::class, 'id_beli', 'id_beli');
    }

    public function biaya()
    {
        return $this->belongsTo(Biaya::class, 'id_biaya', 'id_biaya');
    }

    public function detailBeli()
    {
        return $this->hasMany(DetailBeli::class, 'id_beli', 'id_beli');
    }

    public function keluarKas()
    {
        return $this->hasMany(Kas::class, 'id_keluarkas', 'id_keluarkas');
    }

public static function boot()
{
    parent::boot();
    static::creating(function ($pengeluaranKas) {
        $latestPengeluaranKas = static::latest()->first();
        if (!$latestPengeluaranKas) {
            $pengeluaranKas->id_keluarkas = 'PK-001';
        } else {
            $latestKode = $latestPengeluaranKas->id_keluarkas;
            $number = intval(substr($latestKode, 3, 3));
            $number++;
            $nextNumber = str_pad($number, 3, '0', STR_PAD_LEFT);
            $pengeluaranKas->id_keluarkas = 'PK-' . $nextNumber;
        }
    });
    static::deleting(function ($pengeluaranKas) {
        $pengeluaranKas->keluarKas()->delete();
    });

}
}



