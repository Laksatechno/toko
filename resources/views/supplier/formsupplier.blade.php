@extends('layouts.master')

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Supplier</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Supplier</a></li>
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
              <button class="btn btn-success" data-toggle="modal" data-target="#tambahModal">Tambah Supplier</button>
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
              <table class="table">
                <thead>
                  <tr>
                    <th>ID Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($suppliers as $supplier)
                  <tr>
                    <td>{{ $supplier->kd_supplier }}</td>
                    <td>{{ $supplier->nama_supplier }}</td>
                    <td>{{ $supplier->alamat }}</td>
                    <td>{{ $supplier->no_telp }}</td>
                    <td>
                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $supplier->kd_supplier }}"><i class="fas fa-edit"></i> </button>
                      <form action="{{ route('supplier.destroy', $supplier->kd_supplier) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            
          </div>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Modal Tambah Supplier -->
  <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahModalLabel">Tambah Supplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Isi form tambah supplier -->
          <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="nama_supplier">Nama Supplier</label>
              <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" required>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
              <label for="no_telp">No. Telp</label>
              <input type="text" class="form-control" id="no_telp" name="no_telp" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit Supplier -->
  @foreach ($suppliers as $supplier)
  <div class="modal fade" id="editModal{{ $supplier->kd_supplier }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $supplier->kd_supplier }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel{{ $supplier->kd_supplier }}">Edit Supplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Isi form edit supplier -->
          <form action="{{ route('supplier.update', $supplier->kd_supplier) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="edit_nama_supplier{{ $supplier->kd_supplier }}">Nama Supplier</label>
              <input type="text" class="form-control" id="edit_nama_supplier{{ $supplier->kd_supplier }}" name="nama_supplier" value="{{ $supplier->nama_supplier }}" required>
            </div>
            <div class="form-group">
              <label for="edit_alamat{{ $supplier->kd_supplier }}">Alamat</label>
              <input type="text" class="form-control" id="edit_alamat{{ $supplier->kd_supplier }}" name="alamat" value="{{ $supplier->alamat }}" required>
            </div>
            <div class="form-group">
              <label for="edit_no_telp{{ $supplier->kd_supplier }}">No. Telp</label>
              <input type="text" class="form-control" id="edit_no_telp{{ $supplier->kd_supplier }}" name="no_telp" value="{{ $supplier->no_telp }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach

@endsection
