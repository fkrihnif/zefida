@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tim</h1>
        <a href="#" data-toggle="modal" data-target="#tambah"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah Agen</i></a>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body" style="background-color: #f5f6fa">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id_Agen</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Tim Reseller</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $i = 1;
                        ?>
                        @foreach ($members as $member)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $member->agent_id }}</td>
                            <td>{{ $member->username }}</td>
                            <td>{{ $member->name }} <br>
                            <b style="font-size: 85%">Total Point:</b> {{ $member->total_point }}
                            </td>
                            <td>
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach ($member->reseller as $key=>$reseller)
                                    <?php if($count == 3) break; ?>
                                        <li style="font-size: 80%">{{ $reseller->name }} - ({{$reseller->point}})</li>
                                    <?php $count++; ?>
                                    @endforeach
                                    @if (count($member->reseller) > 3)
                                        <i style="font-size: 90%">....</i>
                                    @endif
                             
                            </td>
                            <td>
                                <a href="{{ route('admin.member.detail', $member->id) }}"><i class="fa fa-eye"></i></a>
                                | <a href="#" data-target="#delete" data-toggle="modal" data-id="{{ $member->id }}"><i class="fas fa-trash"></i></a> | <a href="#" style="color: orange" data-target="#reset" data-toggle="modal" data-id="{{ $member->id }}"><i class="fas fa-cog" style="font-size: 80%">Reset Password</i></a>
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
            <form action="{{ route('admin.member.resetPassword') }}" method="POST">
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
                    <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.member.delete') }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Hapus</span> Member dan Tim</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Member dan Tim ini ? <b><i>semua rekapan point dan penjualan yang telah dilakukan Member dan Tim juga akan terhapus</i></b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.member.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Tambah</span> Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autocomplete="off">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required autocomplete="off">
                                @error('username')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="agent_id">Id_Agen</label>
                                <input type="text" class="form-control @error('agent_id') is-invalid @enderror" id="agent_id" name="agent_id" value="{{ old('agent_id') }}" required autocomplete="off">
                                @error('agent_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" required autocomplete="off">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <i style="font-size: 70%" class="ml-3">Silahkan kosongkan reseller jika blm ada tim</i>
                    <div class="row input_fields_wrap">
                        <div class="col-5">
                            <div class="form-group ml-3">
                                <label for="name_reseller">Nama Reseller</label>
                                <input type="text" class="form-control @error('name_reseller') is-invalid @enderror" id="name_reseller" name="name_reseller[]" value="{{ old('name_reseller') }}" autocomplete="off">
                                @error('name_reseller')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="reseller_id">ID Reseller</label>
                                <input type="text" class="form-control @error('reseller_id') is-invalid @enderror" id="reseller_id" name="reseller_id[]" value="{{ old('reseller_id') }}" autocomplete="off">
                                @error('reseller_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <button type="button" id="tambahKolom" class="btn btn-primary add_field_button" style="margin-top: 27px;">Tambah</button>
                        </div>
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
        $('#edit').find('input[name="id"]').val(id);
        $('#edit').find('input[name="name"]').val(name);
    });
    
    $('#delete').on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');
        $('#delete').find('input[name="id"]').val(id);
    });

     //utk tambah yg sudah ada
     $(document).ready(function() {
        var max_fields      = 50; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append(`
                    <div class="container">
                        <div class="row input_fields_wrap">
                            <div class="col-5">
                                <div class="form-group">
                                <label for="name_reseller">Nama Reseller</label>
                                <input type="text" class="form-control @error('name_reseller') is-invalid @enderror" id="name_reseller" name="name_reseller[]" value="{{ old('name_reseller') }}" autocomplete="off">
                                @error('name_reseller')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="reseller_id">ID Reseller</label>
                                    <input type="text" class="form-control @error('reseller_id') is-invalid @enderror" id="reseller_id" name="reseller_id[]" value="{{ old('reseller_id') }}" autocomplete="off">
                                    @error('reseller_id')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-primary remove_field" style="margin-top: 27px;">Hapus</button>
                            </div>
                        </div>
                    </div>`); //add input box
            }
        });
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); 
            $(this).parent().parent().remove(); x--;
        })
    });


</script>


@endpush