@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Tim</h1>
    </a>
    </div>
    <a href="{{ route('admin.tim.index') }}"><i class="fas fa-arrow-left" style="font-size: 85%"> Kembali</i></a>


    <div class="card shadow mb-4 mt-2">
        <div class="card-body" style="background-color: #f5f6fa">
           <div class="row">
            <div class="col-4"><b>Id No</b></div>
            <div class="col-6">: {{ $agent->identity_id }}</div>
            <div class="col-2"><a href="#" data-id="{{ $agent->id }}" data-agent="{{ $agent->identity_id }}" data-username="{{ $agent->username }}" data-name="{{ $agent->name }}" data-toggle="modal" data-target="#edit"><i class="fas fa-edit">Edit</i></a></div>
           </div>
           <div class="row">
            <div class="col-4"><b>Username</b></div>
            <div class="col-8">: {{ $agent->username }}</div>
           </div>
           <div class="row">
            <div class="col-4"><b>Nama</b></div>
            <div class="col-8">: {{ $agent->name }}</div>
           </div>
           <hr>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body" style="background-color: #f5f6fa">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Penjualan Reseller</h1>
                <a href="#" data-toggle="modal" data-target="#tambahReseller"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah Reseller</i></a>
                </a>
            </div>
            <form action="{{ route('admin.tim.detail', $agent->id) }}">
                <div class="row mt-2">
                        <div class="col-4">
                            <input type="month" id="search_month" name="search_month"
                            min="2023-01" value="{{Request::get('search_month')}}">
                            <input type="submit" value="Cari" class="btn btn-primary text-white ml-3">
                        </div>
                </div>
            </form>
            <form action="{{ route('admin.tim.detail', $agent->id) }}">
                <input type="submit" value="Lihat Bulan Ini" class="btn btn-warning btn-sm text-white mt-2">
            </form>
            <div class="table-responsive mt-2">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama - Username</th>
                            <th>Total Penjualan Bulan Ini (paket)</th>

                        </tr>
                    </thead>
    
                    <tbody>
                        <?php
                        $i = 1;
                        ?>
                        @foreach ($agent->agent_reseller as $r)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $r->user->identity_id }} </td>
                            <td>{{ $r->user->name }} - {{ $r->user->username }}</td>
                            <td>{{ $r->user->selling->sum('package_earn') }} <a href="{{ route('admin.tim.detailReseller', ['agent'=>$agent->id,'reseller'=>$r->user->id]) }}"><i class="fas fa-eye"></i></a></td>
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
<div class="modal fade bd-example-modal-lg" id="tambahReseller" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.tim.storeReseller') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Tambah</span> Reseller</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row input_fields_wrap">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name_reseller">Nama</label>
                                <input type="text" class="form-control @error('name_reseller') is-invalid @enderror" id="name_reseller" name="name_reseller" value="{{ old('name_reseller') }}" autocomplete="off" required>
                                @error('name_reseller')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="username_reseller">Username</label>
                                <input type="text" class="form-control @error('username_reseller') is-invalid @enderror" id="username_reseller" name="username_reseller" value="{{ old('username_reseller') }}" autocomplete="off" required>
                                @error('username_reseller')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="reseller_id">ID</label>
                                <input type="text" class="form-control @error('reseller_id') is-invalid @enderror" id="reseller_id" name="reseller_id" value="{{ old('reseller_id') }}" autocomplete="off" required>
                                @error('reseller_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
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
        $("#edit").on('show.bs.modal', (e) => {
            var id = $(e.relatedTarget).data('id');
            var name = $(e.relatedTarget).data('name');
            var username = $(e.relatedTarget).data('username');
            var agent = $(e.relatedTarget).data('agent');
            $('#edit').find('input[name="id"]').val(id);
            $('#edit').find('input[name="name"]').val(name);
            $('#edit').find('input[name="username"]').val(username);
            $('#edit').find('input[name="agent"]').val(agent);
        });

        $("#editReseller").on('show.bs.modal', (e) => {
            var id = $(e.relatedTarget).data('id');
            var name = $(e.relatedTarget).data('name');
            var resellerid = $(e.relatedTarget).data('resellerid');
            $('#editReseller').find('input[name="id"]').val(id);
            $('#editReseller').find('input[name="name"]').val(name);
            $('#editReseller').find('input[name="resellerid"]').val(resellerid);
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
                                <label for="name_reseller">Nama</label>
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
                                    <label for="reseller_id">ID</label>
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