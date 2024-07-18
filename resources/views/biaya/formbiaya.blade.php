@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Biaya</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Biaya</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->   

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <button class="btn btn-success" data-toggle="modal" data-target="#tambahModal">Tambah Biaya</button>
                        </div>

                        <div class="card-body table-responsive">
                                {{-- alert succes --}}
                                @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID Biaya</th>
                                        <th>Nama Biaya</th>
                                        <th>Tanggal</th>
                                        <th>Total Biaya</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biayas as $biaya)
                                    <tr>
                                        <td>{{ $biaya->id_biaya }}</td>
                                        <td>{{ $biaya->nama_biaya }}</td>
                                        <td>{{ $biaya->tanggal_biaya }}</td>
                                        <td>{{ $biaya->total_biaya }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $biaya->id_biaya }}"><i class="fas fa-edit"></i></button>
                                            <form action="{{ route('biaya.destroy', $biaya->id_biaya) }}" method="POST" style="display: inline;">
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
    @foreach ($biayas as $biaya)
    <div class="modal fade" id="editModal{{ $biaya->id_biaya }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Biaya</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('biaya.update', $biaya->id_biaya) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_biaya">Nama Biaya</label>
                            <input type="text" class="form-control" id="nama_biaya" name="nama_biaya" value="{{ $biaya->nama_biaya }}" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_biaya">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal_biaya" name="tanggal_biaya" value="{{ $biaya->tanggal_biaya }}" required>
                        </div>
                        <div class="form-group">
                            <label for="total_biaya">Total Biaya</label>
                            <input type="text" class="form-control" id="total_biaya" name="total_biaya" value="{{ $biaya->total_biaya }}" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

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
                    <form action="{{ route('biaya.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_biaya">Nama Biaya</label>
                            <input type="text" class="form-control" id="nama_biaya" name="nama_biaya" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_biaya">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal_biaya" name="tanggal_biaya" required>
                        </div>
                        <div class="form-group">
                            <label for="total_biaya">Total Biaya</label>
                            <input type="text" class="form-control" id="total_biaya" name="total_biaya" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection