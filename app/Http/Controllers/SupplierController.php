<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //
    public function index()
    {
        $suppliers = Supplier::all();
        return view('supplier.formsupplier', compact('suppliers'));
    }


    public function store(Request $request)
    {
        // Validasi permintaan masuk
        $validatedData = $request->validate([
            'nama_supplier' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
        ]);

        Supplier::create($validatedData);

        return redirect()->route('supplier.index');
    }

    public function update(Request $request, Supplier $supplier)
    {
        // Validasi permintaan masuk
        $request->validate([
            'nama_supplier' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
        ]);

        $supplier->update($request->all()); 

        return redirect()->route('supplier.index');
    }

    public function destroy($kd_supplier)
    {
        $supplier = Supplier::where('kd_supplier', $kd_supplier)->firstOrFail();
        $supplier->delete();

        return redirect()->route('supplier.index');
    }
}
