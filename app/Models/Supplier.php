<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;


    protected $primaryKey = 'kd_supplier'; // Set primary key
    public $incrementing = false; // Disable auto-incrementing
    protected $keyType = 'string'; // Set key type to string
    protected $fillable = [
        'kd_supplier',
        'nama_supplier',
        'alamat',
        'no_telp',
    ];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($supplier) {
            $latestSupplier = static::latest()->first();
    
            if (!$latestSupplier) {
                $supplier->kd_supplier = 'SP001';
            } else {
                $latestKode = $latestSupplier->kd_supplier;
                $number = intval(substr($latestKode, 2)) + 1;
                $nextNumber = str_pad($number, 3, '0', STR_PAD_LEFT);
                $supplier->kd_supplier = 'SP' . $nextNumber;
            }
        });
    }
}
