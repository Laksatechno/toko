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
        Schema::create('penerimaan_kas', function (Blueprint $table) {
            $table->char('id_terimakas', 8)->primary();
            $table->char('keterangan', 25);
            $table->date('tanggal_transaksi');
            $table->integer('jumlah');
            $table->integer('id_jual'); // Tambahkan kolom id_jual
            $table->index('id_jual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan_kas');
    }
};
