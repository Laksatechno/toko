<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailBeli;
use App\Models\Kas;
use App\Models\Pembelian;
use App\Models\Supplier;
use App\Models\PengeluaranKas;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelian = Pembelian::all();
        $barangs = Barang::all(); // Ambil semua data barang
        $sup = Supplier::all();

        return view('pembelian.formpembelian', compact('pembelian','barangs','sup'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
    
            // Membuat ID Pembelian baru
            $get_id = Pembelian::query()->orderBy('created_at', 'DESC')->first();
            if (is_null($get_id)) {
                $id_trx = "PB-001";
            } else {
                $nourut = (int) substr($get_id->id_beli, 3) + 1;
                $id_trx = 'PB-' . str_pad($nourut, 3, '0', STR_PAD_LEFT);
            }
    
            // Simpan data pembelian
            $pembelian = new Pembelian();
            $pembelian->id_beli = $id_trx;
            $pembelian->kd_supplier = $request->input('kd_supplier');
            $pembelian->tanggal_beli = $request->input('tanggal_beli');
            $pembelian->total_beli = $request->input('total_beli');
            $pembelian->bayar = $request->input('bayar');
            $pembelian->kembali = $pembelian->bayar - $pembelian->total_beli;
            $pembelian->save();
    
            // Simpan detail pembelian dan update stok barang
            $items = [];
            foreach ($request->kd_barang as $index => $kd_barang) {
                $jumlah = $request->jumlah[$index] ?? 0;
                $harga = $request->harga[$index] ?? 0;
                $subtotal = $request->subtotal[$index] ?? 0;
    
                $items[] = [
                    'kd_barang' => $kd_barang,
                    'id_beli' => $pembelian->id_beli,
                    'harga' => $harga,
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                ];
    
                // Update stok barang
                $barang = Barang::findOrFail($kd_barang);
                if ($barang->stok < $jumlah) {
                    throw new Exception("Stok barang {$barang->nama_barang} tidak mencukupi.");
                }
                $barang->stok += $jumlah;
                $barang->save();
            }
    
            DetailBeli::insert($items);
    
            // Simpan data ke Pengeluaran Kas
            $pengeluaranKas = new PengeluaranKas();
            $pengeluaranKas->id_beli = $pembelian->id_beli;
            $pengeluaranKas->id_biaya = 0;
            $pengeluaranKas->keterangan = 'Pembelian';
            $pengeluaranKas->tanggal_transaksi = $request->input('tanggal_beli');
            $pengeluaranKas->jumlah = $pembelian->total_beli;
            $pengeluaranKas->save();
    
            // Ambil saldo terakhir
            $lastKas = Kas::orderBy('created_at'
            , 'DESC')->first();
            $lastSaldo = $lastKas ? $lastKas->saldo : 0;

            // buat kas baru dari Pembelian
            $kas = new Kas();
            $kas->id_keluarkas = $pengeluaranKas->id_keluarkas;
            $kas->id_terimakas = 0;
            $kas->tanggal = $request->input('tanggal_beli');
            $kas->keterangan = 'Pembelian';
            $kas->debit = 0;
            $kas->kredit = $pembelian->total_beli;
            if ($lastSaldo <= 0) {
                $kas->saldo = $lastSaldo + $kas->kredit;
            } else {
                $kas->saldo = $lastSaldo - $kas->kredit;
            }
            $kas->save();
    
            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil disimpan.');
        } catch (Exception $e) {

            DB::rollBack();
            dd ($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    

    public function destroy($id_beli)
    {
        $pembelian = Pembelian::findOrFail($id_beli);
        $detail_belis = DetailBeli::where('id_beli', $id_beli)->get();
        foreach ($detail_belis as $detail_beli) {
            $barang = Barang::find($detail_beli->kd_barang);
            $barang->stok -= $detail_beli->jumlah;
            $barang->save();
        }

        $pengeluaranKas = PengeluaranKas::where('id_beli', $id_beli)->first();

        if ($pengeluaranKas) {
            $kas = Kas::where('id_keluarkas', $pengeluaranKas->id_keluarkas)->first();
            if ($kas) {
                $kas->delete();
            }
            $pengeluaranKas->delete();
        }
        $pembelian->delete();
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus.');
    }
    
    public function cetak_faktur($id_beli){
        $pembelian = Pembelian::findOrFail($id_beli);
        $detail_belis = DetailBeli::where('id_beli', $id_beli)->get();
        $sup = Supplier::findOrFail($pembelian->kd_supplier);
        $pdf = PDF::loadView('pembelian.faktur_pembelian', compact('pembelian','detail_belis','sup'));
        return $pdf->stream( 'faktur-pembelian.pdf' );
    }
    
}
