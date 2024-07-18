@extends('layouts.master')

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">User</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">User</a></li>
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
                <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#createUserModal">
                    Tambah
                  </button>
                  @if (session('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                      {{ session('success') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  @endif
              <div class="d-flex justify-content-between table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>id User</th>
                <th>Username</th>
                <th>Level</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->user_id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->level }}</td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal{{$user->user_id}}"><i class="fas fa-edit"></i></button>
                </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="editUserModal{{$user->user_id}}" tabindex="-1" role="dialog" aria-labelledby="editUserModal{{$user->user_id}}Label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModal{{$user->user_id}}Label">Edit User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('user.update', $user->user_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="edit_username{{$user->user_id}}">Username:</label>
                                    <input type="text" class="form-control" id="edit_username{{$user->user_id}}" name="username" value="{{ $user->username }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_password{{$user->user_id}}">Password:</label>
                                    <input type="password" class="form-control" id="edit_password{{$user->user_id}}" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_level{{$user->user_id}}">Level:</label>
                                    <select class="form-control" id="edit_level{{$user->user_id}}" name="level">
                                        <option value="admin" {{ $user->level == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="pegawai" {{ $user->level == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                                        <option value="pemilik" {{ $user->level == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createUserModalLabel">Tambah Pengguna Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
              <label for="level">Level:</label>
              <select class="form-control" id="level" name="level">
                <option value="admin">Admin</option>
                <option value="pegawai">Pegawai</option>
                <option value="pemilik">Pemilik</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
</div>
            </div></div></div></div></div></div>
@endsection
