<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;

    protected $table = 'kas';
    protected $primaryKey = 'id_kas';
    public $incrementing = false;


    protected $fillable = ['id_kas', 'id_terimakas', 'id_keluarkas', 'tanggal', 'keterangan', 'debit', 'kredit', 'saldo'];

    public function terimaKas()
    {
        return $this->belongsTo(PenerimaanKas::class, 'id_terimakas', 'id_terimakas');
    }

    public function keluarKas()
    {
        return $this->belongsTo(PengeluaranKas::class, 'id_keluarkas', 'id_keluarkas');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($kas) {
            $latestKas = static::latest()->first();
            if (!$latestKas) {
                $kas->id_kas = 'KS-001';
            } else {
                $latestKode = $latestKas->id_kas;
                $number = intval(substr($latestKode, 3, 3));
                $number++;
                $nextNumber = str_pad($number, 3, '0', STR_PAD_LEFT);
                $kas->id_kas = 'KS-' . $nextNumber;
            }
        });
    }

}
