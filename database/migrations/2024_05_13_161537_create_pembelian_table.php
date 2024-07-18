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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->char('id_beli', 8)->primary();
            $table->date('tanggal_beli');
            $table->integer('total_beli');
            $table->char('kd_supplier', 8)->index();
            $table->bigInteger('bayar');
            $table->bigInteger('kembali');
            $table->timestamps(); // Tambahkan kolom created_at dan updated_at secara otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
