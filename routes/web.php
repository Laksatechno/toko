<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/login');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user/{user_id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user_id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');

    // Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    // Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
    // Route::get('/barang/edit/{kd_barang}', [BarangController::class, 'edit'])->name('barang.edit');
    // Route::put('barang/update/{kd_barang}', [BarangController::class, 'update'])->name('barang.update');


    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
    Route ::delete('/barang/{kd_barang}', [BarangController::class, 'destroy'])->name('barang.destroy');

    Route::get('/suppliers', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('supplier.store');
    Route::delete('/suppliers/{kd_supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');

    Route::get('/biaya', [BiayaController::class, 'index'])->name('biaya.index');
    Route::post('/biaya', [BiayaController::class, 'store'])->name('biaya.store');
    Route::delete('/biaya/{id_biaya}', [BiayaController::class, 'destroy'])->name('biaya.destroy');
    Route::put('/biaya/{biaya}', [BiayaController::class, 'update'])->name('biaya.update'); 

    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::put('/penjualan/{penjualan}', [PenjualanController::class, 'update'])->name('penjualan.update');
    Route::delete('/penjualan/{id_jual}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
    Route::get('penjualan/cetak_faktur/{id_jual}', [PenjualanController::class, 'cetak_faktur'])->name('penjualan.cetak_faktur');

    Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
    Route::post('/pembelian', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::delete('/pembelian/{id_beli}', [PembelianController::class, 'destroy'])->name('pembelian.destroy');
    Route::put('/pembelian/{pembelian}', [PembelianController::class, 'update'])->name('pembelian.update');
    Route::get('/pembelian/cetak_faktur/{id_beli}', [PembelianController::class, 'cetak_faktur'])->name('pembelian.cetak_faktur');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak_penjualan/{tgl1}/{tgl2}', [LaporanController::class, 'cetak_penjualan'])->name('laporan.cetak_penjualan');
    Route::get('/laporan/cetak_pembelian/{tgl1}/{tgl2}', [LaporanController::class, 'cetak_pembelian'])->name('laporan.cetak_pembelian'); 
    Route::get('/laporan/cetak_buku_besar{tgl1}/{tgl2}', [LaporanController::class, 'cetak_buku_besar'])->name('laporan.cetak_buku_besar');
    Route::get('/laporan/cetak_penerimaan_kas{tgl1}/{tgl2}', [LaporanController::class, 'cetak_penerimaan_kas'])->name('laporan.cetak_penerimaan_kas');
    Route::get('/laporan/cetak_pengeluaran_kas{tgl1}/{tgl2}', [LaporanController::class, 'cetak_pengeluaran_kas'])->name('laporan.cetak_pengeluaran_kas');

    // Route::post('/laporan/cetak_laba_rugi', [LaporanController::class, 'cetak_laba_rugi_post'])->name('laporan.cetak_laba_rugi_post');
    // Route::post('/laporan/cetak_buku_besar', [LaporanController::class, 'cetak_buku_besar_post'])->name('laporan.cetak_buku_besar_post');
    // Route::post('/laporan/cetak_penjualan', [LaporanController::class, 'cetak_penjualan_post'])->name('laporan.cetak_penjualan_post');
    // Route::post('/laporan/cetak_pembelian', [LaporanController::class, 'cetak_pembelian_post'])->name('laporan.cetak_pembelian_post');
    // Route::post('/laporan/cetak_penerimaan_kas', [LaporanController::class, 'cetak_penerimaan_kas_post'])->name('laporan.cetak_penerimaan_kas_post');
    // Route::post('/laporan/cetak_pengeluaran_kas', [LaporanController::class, 'cetak_pengeluaran_kas_post'])->name('laporan.cetak_pengeluaran_kas_post');

});