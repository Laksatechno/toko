<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\Kas;
use App\Models\PengeluaranKas;
use Illuminate\Http\Request;

class BiayaController extends Controller
{
    //
    public function index()
    {
        $biayas = Biaya::orderBy('id_biaya')->get();
        return view('biaya.formbiaya', compact('biayas'));
    }

 public function store(Request $request)
{
    try {
        // Mengambil data biaya terakhir
        $get_id = Biaya::query()->take(1)->orderBy('created_at','DESC')->first();

        // Membuat ID biaya baru
        if ($get_id == "") {
            $id_biaya = "BY-001";
        } else {
            $nourut = (int) substr($get_id->id_biaya, 3, 3);
            $nourut++;
            $char = "BY-";
            $id_biaya = $char . sprintf("%03s", $nourut);
        }

        // Membuat entri baru di tabel Biaya
        Biaya::create([
            'id_biaya'      => $id_biaya,
            'nama_biaya'    => $request->input('nama_biaya'),
            'tanggal_biaya' => $request->input('tanggal_biaya'),
            'total_biaya'   => $request->input('total_biaya')
        ]);

        // Membuat entri baru di tabel pengeluaran_kas
        $pengeluaranKas = new PengeluaranKas();
        $pengeluaranKas->id_beli = 0;
        $pengeluaranKas->id_biaya = $id_biaya;
        $pengeluaranKas->keterangan = $request->input('nama_biaya');
        $pengeluaranKas->tanggal_transaksi = date('Y-m-d');
        $pengeluaranKas->jumlah = $request->input('total_biaya');
        $pengeluaranKas->save();
        
        // Membuat entri baru di tabel kas
        $lastKas = Kas::orderBy('created_at', 'DESC')->first();
        $lastSaldo = $lastKas ? $lastKas->saldo : 0;
        $kas = new Kas();
        $kas->id_terimakas = 0;
        $kas->id_keluarkas = $id_biaya;
        $kas->keterangan = $request->input('nama_biaya');
        $kas->tanggal = date('Y-m-d');
        $kas->kredit = $request->input('total_biaya');
        $kas->debit = 0;
        if ($lastSaldo <= 0) {
            $kas->saldo = $lastSaldo + $kas->kredit;
        } else {
            $kas->saldo = $lastSaldo - $kas->kredit;
        }
        $kas->save();

        // Redirect dan berikan pesan sukses
        return redirect()->route('biaya.index')->with('success', 'Data berhasil ditambahkan');
    } catch (\Exception $e) {
        dd($e->getMessage());

        // Tangani kesalahan dan kembalikan ke halaman sebelumnya dengan pesan kesalahan
        return redirect()->back()->withErrors(['error' => 'Gagal menambahkan data biaya.']);
    }
}
    

    public function update(Request $request, Biaya $biaya)
    {
        $validatedData = $request->validate([
            'nama_biaya' => 'required',
            'tanggal_biaya' => 'required',
            'total_biaya' => 'required',


        ]);

        $biaya->update($request->all());
        return redirect()->route('biaya.index') ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id_biaya)
    {
        $biaya = Biaya::where('id_biaya', $id_biaya)->firstOrFail();
        $biaya->delete();
        return redirect()->route('biaya.index') ->with('success', 'Data berhasil dihapus');
    }


}
