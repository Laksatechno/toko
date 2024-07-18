<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biaya extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_biaya'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $fillable = [

        'id_biaya',
        'nama_biaya',
        'tanggal_biaya',
        'total_biaya',
    ];

    public function detailJual()
    {
        return $this->hasMany(DetailJual::class, 'id_biaya', 'id_biaya');
    }

    public function Kas()
    {
     return $this->hasMany(Kas::class, 'id_keluarkas', 'id_biaya');   
    }

    public function keluarKas()
    {
        return $this->hasMany(PengeluaranKas::class, 'id_biaya', 'id_biaya');
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($biaya) {
    //         $latestBiaya = static::latest()->first();
    
    //         if (!$latestBiaya) {
    //             $biaya->id_biaya = 'BY001';
    //         } else {
    //             $latestKode = $latestBiaya->id_biaya;
    //             $number = intval(substr($latestKode, 2)) + 1;
    //             $nextNumber = str_pad($number, 3, '0', STR_PAD_LEFT);
    //             $biaya->id_biaya = 'BY' . $nextNumber;
    //         }
    //     });
    // }
    public static function boot(){
        parent::boot();
        static::deleting(function($biaya){
            $biaya -> Kas()->delete();
            $biaya -> keluarKas()->delete();
        });
    }
}
