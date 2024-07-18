<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanKas extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_terimakas';
    public $incrementing = false;

    protected $fillable = [
        'id_terimakas',
        'keterangan',
        'tanggal_transaksi',
        'jumlah',
        'id_jual'
    ];

    public function jual()  
    {
        return $this->belongsTo(Penjualan::class, 'id_jual', 'id_jual');
    }

    public function detailJual()
    {
        return $this->hasMany(DetailJual::class, 'id_jual', 'id_jual');
    }

    public function terimaKas()
    {
        return $this->hasMany(Kas::class, 'id_terimakas', 'id_terimakas');
    }



    public static function boot()
    {
        parent::boot();
        static::creating(function ($penerimaanKas) {
            $latestPenerimaanKas = static::latest()->first();
            if (!$latestPenerimaanKas) {
                $penerimaanKas->id_terimakas = 'PK-001';
            } else {
                $latestKode = $latestPenerimaanKas->id_terimakas;
                $number = intval(substr($latestKode, 3, 3));
                $number++;
                $nextNumber = str_pad($number, 3, '0', STR_PAD_LEFT);
                $penerimaanKas->id_terimakas = 'PK-' . $nextNumber;
            }
        });
        static::deleting(function ($penerimaanKas) {
            $penerimaanKas->terimaKas()->delete();
        });
    }
}
