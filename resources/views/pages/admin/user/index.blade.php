@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Agent/Reseller</h1>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body" style="background-color: #f5f6fa">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama - Username</th>
                            <th>Status</th>
                            <th>Aktif?</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $i = 1;
                        ?>
                        @foreach ($users as $u)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $u->identity_id }}</td>
                            <td>{{ $u->name }} - {{ $u->username }}</td>
                            <td>
                                @if ($u->role == 1)
                                <i class="btn btn-sm shadow-sm" style="font-size: 75%; background-color:#2ecc71; color: white">Reseller</i>
                            @elseif ($u->role == 2)
                                <i class="btn btn-sm shadow-sm" style="font-size: 75%; background-color: orange; color: white">Agent</i>
                            @endif
                            </td>
                            <td>
                                @if ($u->is_active == 1)
                                    <i class="btn btn-sm btn-primary shadow-sm" style="font-size: 75%">Aktif</i>
                                @else
                                    <i class="btn btn-sm btn-secondary shadow-sm" style="font-size: 75%">Tidak Aktif</i>
                                @endif
                            </td>
                            <td>
                                <a href="#" data-id="{{ $u->id }}" data-identity="{{ $u->identity_id }}" data-name="{{ $u->name }}" data-isactive="{{ $u->is_active }}" data-toggle="modal" data-target="#edit"><i class="fas fa-edit"></i></a> | <a href="#" data-target="#delete" data-toggle="modal" data-id="{{ $u->id }}"><i class="fas fa-trash"></i></a> | <a href="#" style="color: orange" data-target="#reset" data-toggle="modal" data-id="{{ $u->id }}"><i class="fas fa-cog" style="font-size: 80%">Reset Password</i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- /.container-fluid -->
{{-- modal --}}
<div class="modal fade" id="reset" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.tim.resetPassword') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Reset</span> Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin mereset password Akun ini ? Password akan direset menjadi : password123
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.user.delete') }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Hapus</span> User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus user ? <b><i>semua rekapan penjualan yang telah dilakukan Agent dan Tim yang berkaitan juga akan terhapus</i></b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.user.update') }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Ubah</span> Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="identity_id">Id</label>
                        <input type="text" class="form-control @error('identity_id') is-invalid @enderror" id="identity_id" name="identity_id" required>
                        @error('identity_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                        @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="isctive">Aktif ?</label>
                            <select name="isactive" id="isactive"
                                class="form-control " required autofocus>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>  
    </div>
</div>


@endsection
@push('addon-script')
<script>
    $('#reset').on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');
        $('#reset').find('input[name="id"]').val(id);
    });
    $("#edit").on('show.bs.modal', (e) => {
            var id = $(e.relatedTarget).data('id');
            var name = $(e.relatedTarget).data('name');
            var identity = $(e.relatedTarget).data('identity');
            var isactive = $(e.relatedTarget).data('isactive');
            $('#edit').find('input[name="id"]').val(id);
            $('#edit').find('input[name="name"]').val(name);
            $('#edit').find('input[name="identity_id"]').val(identity);
            $('#edit').find('select[name="isactive"]').val(isactive);
        });
    
    $('#delete').on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');
        $('#delete').find('input[name="id"]').val(id);
    });

</script>


@endpush