@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-0 text-gray-800">Detail Tim</h1>
    </a>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-1">
        <a href="{{ route('admin.tim.index') }}"><i class="fas fa-arrow-left" style="font-size: 85%"> Kembali</i></a>
        <a href="#" data-id="{{ $agent->id }}" data-agent="{{ $agent->identity_id }}" data-name="{{ $agent->name }}" data-toggle="modal" data-target="#edit"><i class="fas fa-edit" style="font-size: 100%">Edit Agent</i></a>
    </div>

    <div class="card shadow mb-4 mt-2">
        <div class="card-body" style="background-color: #f5f6fa">
           <div class="row">
            <div class="col-4"><b>Id No</b></div>
            <div class="col-8">: {{ $agent->identity_id }}</div>
           </div>
           <div class="row">
            <div class="col-4"><b>Username</b></div>
            <div class="col-8">: {{ $agent->username }}</div>
           </div>
           <div class="row">
            <div class="col-4"><b>Nama</b></div>
            <div class="col-8">: {{ $agent->name }}</div>
           </div>
           <div class="row">
            <div class="col-4"><b>Penjualan Bulan Ini</b></div>
            <div class="col-8">: {{ $agent->selling->sum('package_earn') }} Paket <a href="{{ route('admin.tim.detailReseller', ['agent'=>$agent->id,'reseller'=>$agent->id]) }}"><i class="fas fa-eye"></i></a></div>
           </div>
           <hr>

           @php
           $tp_tim = [];
           @endphp
           @foreach ($total_penjualan_tim_tahun as $tpt)
           @php
           $tp_tim[] = $tpt->selling->sum('package_earn') ;
           @endphp
           @endforeach
           @php
           $totalPurchase = array_sum($tp_tim);
           @endphp
           
     
           @php
           $tp_tim_bulan = [];
           @endphp
           @foreach ($total_penjualan_tim_bulan as $tpt_bulan)
           @php
           $tp_tim_bulan[] = $tpt_bulan->selling->sum('package_earn') ;
           @endphp
           @endforeach
           @php
           $totalPurchaseBulan = array_sum($tp_tim_bulan);
           @endphp
    
           @php
           $c = [];
           @endphp
           @foreach ($bonus_bulan as $bb)
           @php
           $c[] = $bb->selling->sum('bonus_earn') ;
           @endphp
           @endforeach
           @php
           $totalC = array_sum($c);
           @endphp
  
       <table border="1" style="float:right">
           <tbody>
           <tr><td style="padding: 3px; font-size: 90%;">Total Penjualan Pribadi {{ \Carbon\Carbon::now()->year }}</td><td style="padding: 3px; font-size: 90%; width: 40%; text-align:center">@foreach ($total_penjualan_pribadi_tahun as $tpp)
               {{ $tpp->selling->sum('package_earn') }} Paket
               @endforeach  </td></tr>
           <tr><td style="padding: 3px;font-size: 90%;">Total Penjualan Tim {{ \Carbon\Carbon::now()->year }}</td><td style="padding: 3px; font-size: 90%;text-align:center">{{ $totalPurchase }} Paket</td></tr>
           <tr><td style="padding: 3px;font-size: 90%;">Total Penjualan Tim Bulan Ini</td><td style="padding: 3px; font-size: 90%;text-align:center">{{ $totalPurchaseBulan }} Paket</td></tr>
           <tr><td style="padding: 3px;font-size: 90%;">Bonus Bulan Ini</td><td style="padding: 3px; font-size: 90%;text-align:center"><b>@currency($totalC)</b></td></tr>
           </tbody>
       </table>

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
                            <th>Nama</th>
                            <th>Total Penjualan Bulan Ini (paket)</th>

                        </tr>
                    </thead>
    
                    <tbody>
                        <?php
                        $i = 1;
                        ?>
                        @foreach ($agent->agent_reseller as $r)
                        @if ($r->user->is_active == 0)
                            
                        @else                        
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $r->user->identity_id }} <a href="#" data-id="{{ $r->user->id }}" data-resellerid="{{ $r->user->identity_id }}" data-name="{{ $r->user->name }}" data-isactive="{{ $r->user->is_active }}" data-toggle="modal" data-target="#editReseller"><i class="fas fa-edit" style="font-size: 70%"></i></a> </td>
                            <td>{{ $r->user->name }}</td>
                            <td>{{ $r->user->selling->sum('package_earn') }} <a href="{{ route('admin.tim.detailReseller', ['agent'=>$agent->id,'reseller'=>$r->user->id]) }}"><i class="fas fa-eye"></i></a></td>
                        </tr>
                        @endif
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

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.tim.updateAgent') }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Ubah</span> Data Agen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="agent">Id</label>
                        <input type="text" class="form-control @error('agent') is-invalid @enderror" id="agent" name="agent" required>
                        @error('agent')
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
            <form action="{{ route('admin.tim.updateReseller') }}" enctype="multipart/form-data" method="POST">
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
                        <label for="resellerid">Id Reseller</label>
                        <input type="text" class="form-control @error('resellerid') is-invalid @enderror" id="resellerid" name="resellerid" required>
                        @error('resellerid')
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
        $("#edit").on('show.bs.modal', (e) => {
            var id = $(e.relatedTarget).data('id');
            var name = $(e.relatedTarget).data('name');
            var agent = $(e.relatedTarget).data('agent');
            $('#edit').find('input[name="id"]').val(id);
            $('#edit').find('input[name="name"]').val(name);
            $('#edit').find('input[name="agent"]').val(agent);
        });

        $("#editReseller").on('show.bs.modal', (e) => {
            var id = $(e.relatedTarget).data('id');
            var name = $(e.relatedTarget).data('name');
            var resellerid = $(e.relatedTarget).data('resellerid');
            var isactive = $(e.relatedTarget).data('isactive');
            $('#editReseller').find('input[name="id"]').val(id);
            $('#editReseller').find('input[name="name"]').val(name);
            $('#editReseller').find('input[name="resellerid"]').val(resellerid);
            $('#editReseller').find('select[name="isactive"]').val(isactive);
        });

    </script>




@endpush