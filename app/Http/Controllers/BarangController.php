<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Validator;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::orderBy('kd_barang')->get();
        return view('barang.formbarang', compact('barangs'));
    }

    // Berfungsi untuk menangani penambahan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'stok' => 'required|numeric',
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')
                         ->with('success', 'Barang added successfully');
    }

    // Berfungsi untuk menangani update data
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required',
            'stok' => 'required|numeric',
        ]);

        $barang->update($request->all());

        return redirect()->route('barang.index')
                         ->with('success', 'Barang updated successfully');
    }

    public function destroy ($kd_barang){
        $barang = Barang::find($kd_barang);
        $barang->delete();
        return redirect()->route('barang.index')
                         ->with('success', 'Barang deleted successfully');
    }
}
