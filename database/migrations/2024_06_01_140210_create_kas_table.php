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
        Schema::create('kas', function (Blueprint $table) {
                $table->char('id_kas', 8)->primary();
                $table->char('id_terimakas', 8)->index();
                $table->char('id_keluarkas', 8)->index();
                $table->date('tanggal');
                $table->char('keterangan', 25);
                $table->integer('debit');
                $table->integer('kredit');
                $table->float('saldo');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas');
    }
};
