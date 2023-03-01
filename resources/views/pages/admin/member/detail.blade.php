@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800">Detail Member</h1>
    
    <a href="{{ route('admin.member.index') }}"><i class="fas fa-arrow-left" style="font-size: 85%"> Kembali</i></a>


    <div class="card shadow mb-4 mt-2">
        <div class="card-body">
           <div class="row">
            <div class="col-4"><b>Id_Agen</b></div>
            <div class="col-6">: {{ $member->agent_id }}</div>
            <div class="col-2"><a href="#" data-id="{{ $member->id }}" data-agent="{{ $member->agent_id }}" data-username="{{ $member->username }}" data-name="{{ $member->name }}" data-toggle="modal" data-target="#edit"><i class="fas fa-edit">Edit</i></a></div>
           </div>
           <div class="row">
            <div class="col-4"><b>Username</b></div>
            <div class="col-8">: {{ $member->username }}</div>
           </div>
           <div class="row">
            <div class="col-4"><b>Nama</b></div>
            <div class="col-8">: {{ $member->name }}</div>
           </div>
           <div class="row">
            <div class="col-4"><b>Total Point</b></div>
            <div class="col-8">: {{ $member->total_point }}</div>
           </div>
           <hr>
           <div class="row">
                <div class="col-4"><b>Tim Reseller</b></div>
                <div class="col-8">
                    @if (!$member->reseller->isEmpty())
                    @foreach ($member->reseller as $reseller)
                        <li>{{ $reseller->name }} - ({{$reseller->point}}) &nbsp;&nbsp; <a href="#" data-id="{{ $reseller->id }}" data-name="{{ $reseller->name }}" data-point="{{ $reseller->point }}" data-toggle="modal" data-target="#editReseller"><i class="fas fa-edit" style="font-size: 75%"></i></a></li> 
                    @endforeach
                @else
                    <i style="font-size:90%; color: grey">--Belum Ada Tim--</i>
                @endif
                </div>
           </div>
        </div>
    </div>

</div>

<!-- /.container-fluid -->
{{-- modal --}}
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.member.update') }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Ubah</span> Data Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="agent">Id_Agen</label>
                        <input type="text" class="form-control @error('agent') is-invalid @enderror" id="agent" name="agent" required>
                        @error('agent')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" required>
                        @error('username')
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>  
    </div>
</div>


<div class="modal fade" id="editReseller" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.member.updateReseller') }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Ubah</span> Data Reseller</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                        <label for="point">Point</label>
                        <input type="text" class="form-control @error('point') is-invalid @enderror" id="point" name="point" required>
                        @error('point')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
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
            var point = $(e.relatedTarget).data('point');
            $('#editReseller').find('input[name="id"]').val(id);
            $('#editReseller').find('input[name="name"]').val(name);
            $('#editReseller').find('input[name="point"]').val(point);
        });
    </script>


@endpush