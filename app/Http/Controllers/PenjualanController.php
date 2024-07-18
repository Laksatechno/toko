<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailJual;
use App\Models\Kas;
use App\Models\Penjualan;
use App\Models\PenerimaanKas;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::all();
        $barangs = Barang::all(); // Ambil semua data barang
        return view('penjualan.formpenjualan', compact('penjualans','barangs'));
    }

    // public function store(Request $request)
    // {
    //     // Validasi input jika diperlukan

    //     // Simpan data penjualan ke dalam database
    //     $penjualan = new Penjualan;
    //     $penjualan->id_jual = $request->input('id_jual');
    //     $penjualan->tanggal_jual = $request->input('tanggal_jual');
    //     $penjualan->total_jual = $request->input('total_jual');
    //     $penjualan->bayar = $request->input('bayar');
    //     $penjualan->kembali = $request->input('kembali');
    //     $penjualan->save();

        
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'total' => 'required|numeric',
    //         'bayar' => 'required|numeric',
    //         'kembalian' => 'required|numeric',
    //         'detail_items' => 'required|array|min:1',
    //         'detail_items.*.kd_barang' => 'required|exists:barangs,kd_barang',
    //         'detail_items.*.jumlah' => 'required|integer|min:1',
    //         'detail_items.*.harga' => 'required|numeric|min:0',
    //         'detail_items.*.subtotal' => 'required|numeric|min:0',
    //     ]);

    //     $penjualan = Penjualan::create([
    //         'tanggal_jual' => now(),
    //         'total_jual' => $request->input('total'),
    //         'bayar' => $request->input('bayar'),
    //         'kembali' => $request->input('kembalian')
    //     ]);

    //     foreach ($request->input('detail_items') as $item) {
    //         DetailJual::create([
    //             'id_jual' => $penjualan->id_jual,
    //             'kd_barang' => $item['kd_barang'],
    //             'jumlah' => $item['jumlah'],
    //             'harga' => $item['harga'],
    //             'subtotal' => $item['subtotal']
    //         ]);
    //     }

    //     return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil disimpan.');
    // }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Membuat ID Penjualan baru
            $get_id = Penjualan::query()->orderBy('created_at', 'DESC')->first();
            if (is_null($get_id)) {
                $id_trx = "PJ-001";
            } else {
                $nourut = (int) substr($get_id->id_jual, 3, 3);
                $nourut++;
                $char = "PJ-";
                $id_trx = $char . sprintf("%03s", $nourut);
            }

            // Simpan data penjualan
            $penjualan = new Penjualan();
            $penjualan->id_jual = $id_trx;
            $penjualan->tanggal_jual = $request->input('tanggal_jual');
            $penjualan->total_jual = $request->input('total_jual');
            $penjualan->bayar = $request->input('bayar');
            $penjualan->kembali = $request->input('kembali');
            $penjualan->save();

            // Simpan detail penjualan dan update stok barang
            $items = [];
            foreach ($request->kd_barang as $index => $kd_barang) {
                $jumlah = $request->jumlah[$index] ?? 0;
                $harga = $request->harga[$index] ?? 0;
                $subtotal = $request->subtotal[$index] ?? 0;

                $items[] = [
                    'kd_barang' => $kd_barang,
                    'id_jual' => $penjualan->id_jual,
                    'harga' => $harga,
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                ];

                // Update stok barang
                $barang = Barang::findOrFail($kd_barang);
                if ($barang->stok < $jumlah) {
                    throw new Exception("Stok barang {$barang->nama_barang} tidak mencukupi.");
                }
                $barang->stok -= $jumlah;
                $barang->save();
            }

            DetailJual::insert($items);

                // Simpan data ke penerimaan_kas
                $penerimaanKas = new PenerimaanKas();
                $penerimaanKas->keterangan = 'Penjualan';
                $penerimaanKas->tanggal_transaksi = $request->input('tanggal_jual');
                $penerimaanKas->jumlah = $penjualan->total_jual;
                $penerimaanKas->id_jual = $penjualan->id_jual;
                $penerimaanKas->save();

                // Ambil saldo terakhir
                $lastKas = Kas::orderBy('created_at', 'DESC')->first();
                $lastSaldo = $lastKas ? $lastKas->saldo : 0;
            

                $kas = new Kas();

                $kas->id_terimakas = $penerimaanKas->id_terimakas;
                $kas->id_keluarkas = 0;
                $kas->tanggal = $request->input('tanggal_jual');
                $kas->keterangan = 'Penjualan';
                $kas->debit = $penjualan->total_jual;
                $kas->kredit = 0;

                // Update saldo terakhir
                if ($lastSaldo <= 0) {
                    $kas->saldo = $lastSaldo + $kas->debit;
                } else {
                    $kas->saldo = $lastSaldo + $kas->debit;
                }

                $kas->save();

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id_jual)
    {
        $penjualan = Penjualan::findOrFail($id_jual);
        $detail_juals = DetailJual::where('id_jual', $id_jual)->get();
        foreach ($detail_juals as $detail_jual) {
            $barang = Barang::find($detail_jual->kd_barang);
            $barang->stok += $detail_jual->jumlah;
            $barang->save();
        }

        $penerimaanKas = PenerimaanKas::where('id_jual', $id_jual)->first();
        if ($penerimaanKas) {
            $kas = Kas::where('id_terimakas', $penerimaanKas->id_terimakas)->first();
            if ($kas) {
                $kas->delete();
            }
            $penerimaanKas->delete();
        }
        $penjualan->delete();
    
        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus');
    }

    public function cetak_faktur($id_jual)
    {
        $penjualans = Penjualan::find($id_jual);
        
        if (!$penjualans) {
            return redirect()->back()->with('error', 'Data penjualan tidak ditemukan.');
        }
        
        $detail_juals = DetailJual::where('id_jual', $id_jual)->get();
        $pdf = PDF::loadView('penjualan.faktur_penjualan', compact('penjualans', 'detail_juals'))->setOptions(['defaultFont' => 'sans-serif']);
        
        return $pdf->stream( 'faktur_penjualan.pdf');
    }
    

}
