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
        Schema::create('detail_beli', function (Blueprint $table) {
            $table->bigIncrements('id_detbeli');
            $table->char('id_beli', 8)->index();
            $table->char('kd_barang', 8)->index();
            $table->integer('jumlah');
            $table->float('harga');
            $table->float('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_beli');
    }
};
