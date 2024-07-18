@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Barang</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header border-0">

                @if(auth()->user()->level != 'pegawai')
                    <button class="btn btn-success" data-toggle="modal" data-target="#tambahModal">Tambah Barang</button>
                @endif
                             {{-- alert succes --}}
                             @if (session('success'))
                             <div class="alert alert-success alert-dismissible fade show" role="alert">
                                 {{ session('success') }}
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>
                             @endif
            </div>
            <div class="d-flex justify-content-between table-responsive">
                <table class="table">
                <thead>
                    <tr>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        @if(auth()->user()->level != 'pegawai')
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $barang)
                    <tr>
                        <td>{{ $barang->kd_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->stok }}</td>
                        @if(auth()->user()->level != 'pegawai')
                        <td>
                                <!-- Button to trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $barang->kd_barang }}"><i class="fas fa-edit"></i></button>
                                <!-- button delete -->
                                <form action="{{ route('barang.destroy', $barang->kd_barang) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>

            <!-- Modal Tambah Barang -->
            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formTambah" action="{{ route('barang.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="stok">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Barang -->
            @foreach($barangs as $barang)
            <div class="modal fade" id="editModal{{ $barang->kd_barang }}" tabindex="-1" aria-labelledby="editModalLabel{{ $barang->kd_barang }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $barang->kd_barang }}">Edit Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Edit Barang -->
                            <form action="{{ route('barang.update', $barang->kd_barang) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="edit_nama_barang{{ $barang->kd_barang }}">Nama Barang</label>
                                    <input type="text" class="form-control" id="edit_nama_barang{{ $barang->kd_barang }}" name="nama_barang" value="{{ $barang->nama_barang }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_stok{{ $barang->kd_barang }}">Stok</label>
                                    <input type="number" class="form-control" id="edit_stok{{ $barang->kd_barang }}" name="stok" value="{{ $barang->stok }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
      </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Reset form when modal closes
        $('#tambahModal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        });
    });

   
</script>
@endsection
