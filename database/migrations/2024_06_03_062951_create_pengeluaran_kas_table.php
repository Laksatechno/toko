<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengeluaran_kas', function (Blueprint $table) {
            $table->char('id_keluarkas', 8)->primary();
            $table->char('keterangan', 25);
            $table->date('tanggal_transaksi');
            $table->integer('jumlah');
            $table->integer('id_beli'); // Tambahkan kolom id_beli
            $table->integer('id_biaya'); // Tambahkan kolom id_biaya
            $table->index('id_beli'); // Buat indeks untuk kolom id_beli
            $table->index('id_biaya'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_kas');
    }
};
