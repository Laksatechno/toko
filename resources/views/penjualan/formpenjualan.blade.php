@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Penjualan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Penjualan</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-2">
                    <div class="card-header">
                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalPenjualan"><i class="fas fa-plus"></i>Tambah</button>
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table user-table ">
                            <thead>
                                <tr>
                                    <th >No.</th>
                                    <th>Id Jual</th>
                                    <th>Tgl Penjualan</th>
                                    <th>Total</th>
                                    <th>Bayar</th>
                                    <th>Kembali</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse($penjualans as $penjualan)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $penjualan->id_jual }}</td>
                                    <td>{{ $penjualan->tanggal_jual }}</td>
                                    <td>{{ $penjualan->total_jual }}</td>
                                    <td>{{ $penjualan->bayar }}</td>
                                    <td>{{ $penjualan->kembali }}</td>
                                    <td>
                                        <a href="{{ route('penjualan.cetak_faktur',$penjualan->id_jual) }}" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-file-invoice"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $penjualan->id_jual }}')" ><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <form id="delete-form" action="" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal tambah data -->
<div class="modal fade" id="modalPenjualan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('penjualan.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="input-group col-12 mb-3">
                    <input type="date" class="form-control" name="tanggal_jual" id="tanggal_jual" placeholder="Tgl Penjualan" required>
                    </div>
                    <div class="input-group col-12 mb-3">
                       
                        <div class="input-group-prepend">
                            <select name="barang" id="barang" class="form-control">
                                <option value="">--Pilih Barang--</option>
                                @foreach($barangs as $barang)
                                <option value="{{ $barang->kd_barang }}-{{ $barang->nama_barang }}-{{ $barang->harga }}">
                                    {{ $barang->nama_barang }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="kodeBarang">
                        <input type="hidden" id="namaBarang">
                        <input type="text" class="form-control" id="hargaBarang" placeholder="Harga">
                        <input type="text" class="form-control" id="jumlahBarang" placeholder="Jumlah" oninput="this.value = this.value.replace(/[^0-9.]/g,'').replace(/(\..*?)\..*/g, '$1');" onkeyup="hitungSubtotalBarang()">
                        <input type="text" class="form-control" placeholder="Subtotal" id="subTotalBarang" readonly>
                        <button type="button" class="btn btn-success btn-sm" onclick="tambahItem()" id="btnTambahItem"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kd Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="bodyDetail">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" align="right" class="font-weight-bold">Total</td>
                            <td>
                                <span id="totalitems">0</span>
                                <input type="hidden" name="total_jual" class="form-control" id="total_jual">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right" class="font-weight-bold">Bayar</td>
                            <td>
                                <div class="input-group mb-3">
                                    <input type="text" name="bayar" id="bayarTotal" class="form-control" oninput="hitungPembayaran()">
                                    <div class="input-group-appended">
                                        <button type="button" class="btn btn-sm btn-info" onclick="hitungPembayaran()"><i class="fas fa-sync"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right" class="font-weight-bold">Kembali</td>
                            <td>
                                <span id="txtKembali">0</span>
                                <input type="hidden" name="kembali" class="form-control" id="kembali">
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="simpanTrx" disabled>Simpan</button>
            </div>
        </form>
    </div>
</div>


@endsection

<script>


    function confirmDelete(id_jual) {
        if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            var form = document.getElementById('delete-form');
            form.action = '/penjualan/' + id_jual;
            form.submit();
        }
    }

    function tambahItem() {
        var barangSelect = document.getElementById('barang');
        var selectedOption = barangSelect.options[barangSelect.selectedIndex];
        var kodeBarang = selectedOption.value.split('-')[0];
        var namaBarang = selectedOption.value.split('-')[1];
        var hargaBarang = document.getElementById('hargaBarang').value;
        var jumlahBarang = document.getElementById('jumlahBarang').value;
        var subtotalBarang = parseFloat(hargaBarang) * parseInt(jumlahBarang);

        var bodyDetail = document.getElementById('bodyDetail');
        var newRow = bodyDetail.insertRow();
        var cellKodeBarang = newRow.insertCell(0);
        var cellNamaBarang = newRow.insertCell(1);
        var cellHargaBarang = newRow.insertCell(2);
        var cellJumlahBarang = newRow.insertCell(3);
        var cellSubtotalBarang = newRow.insertCell(4);

        cellKodeBarang.innerHTML = `<input type="hidden" name="kd_barang[]" value="${kodeBarang}">${kodeBarang}`;
        cellNamaBarang.innerHTML = namaBarang;
        cellHargaBarang.innerHTML = `<input type="hidden" name="harga[]" value="${hargaBarang}">${hargaBarang}`;
        cellJumlahBarang.innerHTML = `<input type="hidden" name="jumlah[]" value="${jumlahBarang}">${jumlahBarang}`;
        cellSubtotalBarang.innerHTML = `<input type="hidden" name="subtotal[]" value="${subtotalBarang}">${subtotalBarang}`;

        document.getElementById('totalitems').innerHTML = updateTotal();
        document.getElementById('total_jual').value = updateTotal();

        // Reset form input
        document.getElementById('barang').value = '';
        document.getElementById('hargaBarang').value = '';
        document.getElementById('jumlahBarang').value = '';
        document.getElementById('subTotalBarang').value = '';
        document.getElementById('btnTambahItem').disabled = true;
    }

    function hitungSubtotalBarang() {
        var hargaBarang = parseInt(document.getElementById('hargaBarang').value);
        var jumlahBarang = parseInt(document.getElementById('jumlahBarang').value);
        var subtotalBarang = hargaBarang * jumlahBarang;
        document.getElementById('subTotalBarang').value = subtotalBarang;
        document.getElementById('btnTambahItem').disabled = false;
    }

    function hitungPembayaran() {
        var totalJual = parseInt(document.getElementById('total_jual').value);
        var bayar = parseInt(document.getElementById('bayarTotal').value);
        var kembali = bayar - totalJual;
        document.getElementById('txtKembali').innerHTML = kembali;
        document.getElementById('kembali').value = kembali;
    }

    function updateTotal() {
        var table = document.getElementById('bodyDetail');
        var rows = table.getElementsByTagName('tr');
        var total = 0;
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            if (row.cells.length >= 5) {
                var subtotal = parseInt(row.cells[4].getElementsByTagName('input')[0].value);
                if (!isNaN(subtotal)) {
                    total += subtotal;
                }
            }
        }
        document.getElementById('simpanTrx').disabled = false;
        return total;
    }
</script>
