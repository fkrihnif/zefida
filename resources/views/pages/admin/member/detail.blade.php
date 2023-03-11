@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Tim</h1>
        <a href="#" data-toggle="modal" data-target="#tambahReseller"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah Reseller</i></a>
    </a>
    </div>
    <a href="{{ route('admin.member.index') }}"><i class="fas fa-arrow-left" style="font-size: 85%"> Kembali</i></a>


    <div class="card shadow mb-4 mt-2">
        <div class="card-body">
           <div class="row">
            <div class="col-4"><b>Id No</b></div>
            <div class="col-6">: {{ $member->agent_id }}</div>
            <div class="col-2"><a href="#" data-id="{{ $member->id }}" data-agent="{{ $member->agent_id }}" data-username="{{ $member->username }}" data-name="{{ $member->name }}" data-totalp="{{ $member->total_point }}" data-toggle="modal" data-target="#edit"><i class="fas fa-edit">Edit</i></a></div>
           </div>
           <div class="row">
            <div class="col-4"><b>Username</b></div>
            <div class="col-8">: {{ $member->username }}</div>
           </div>
           <div class="row">
            <div class="col-4"><b>Nama</b></div>
            <div class="col-8">: {{ $member->name }}</div>
           </div>
           <hr>
           <div class="row justify-content-end">
            <div class="col-3" style="border: 1px solid black;">
              Total Penjualan Pribadi (th 2023)
            </div>
            <div class="col-3" style="border: 1px solid black;">
                 @foreach ($total_penjualan_pribadi_tahun as $tpp)
                 {{ $tpp->sale->sum('quantity') }}
                 @endforeach
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-3" style="border: 1px solid black;">
              Total Penjualan Tim (th 2023)
            </div>
            <div class="col-3" style="border: 1px solid black;">
                @php
                $tp_tim = [];
                @endphp
                @foreach ($total_penjualan_tim_tahun as $tpt)
                @php
                $tp_tim[] = $tpt->sale->sum('quantity') ;
                @endphp
                @endforeach
                @php
                $totalPurchase = array_sum($tp_tim);
                @endphp
                {{ $totalPurchase }}
            </div>
          </div>
          <br>
          <div class="row justify-content-end">
            <div class="col-3" style="border: 1px solid black;">
              Total Penjualan Tim bulan ini
            </div>
            <div class="col-3" style="border: 1px solid black;">
                @php
                $tp_tim_bulan = [];
                @endphp
                @foreach ($total_penjualan_tim_bulan as $tpt_bulan)
                @php
                $tp_tim_bulan[] = $tpt_bulan->sale->sum('quantity') ;
                @endphp
                @endforeach
                @php
                $totalPurchaseBulan = array_sum($tp_tim_bulan);
                @endphp
                {{ $totalPurchaseBulan }}
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-3" style="border: 1px solid black;">
              Bonus Bulan Ini
            </div>
            <div class="col-3" style="border: 1px solid black;">
                @php
                $c = [];
                @endphp
                @foreach ($bonus_bulan as $bb)
                @php
                $c[] = $bb->sale->sum('bonus_earn') ;
                @endphp
                @endforeach
                @php
                $totalC = array_sum($c);
                @endphp
                @currency($totalC)
            </div>
          </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Penjualan Reseller</h1>
                <a href="#" data-toggle="modal" data-target="#tambah"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah Penjualan</i></a>
                </a>
            </div>
            <form action="{{ route('admin.member.detail', $member->id) }}">
                <div class="row mt-2">
                        <div class="col-4">
                            <input type="month" id="search_month" name="search_month"
                            min="2023-01" value="{{Request::get('search_month')}}">
                            <input type="submit" value="Cari" class="btn btn-primary text-white ml-3">
                        </div>
                </div>
            </form>
            <form action="{{ route('admin.member.detail', $member->id) }}">
                <input type="submit" value="Lihat Bulan Ini" class="btn btn-warning btn-sm text-white mt-2">
            </form>
            <div class="table-responsive mt-2">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID No</th>
                            <th>Agen/Reseller</th>
                            <th>Total Penjualan Bulan Ini</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        <?php
                        $i = 1;
                        ?>
                        @foreach ($resellers as $reseller)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $reseller->reseller_id }} 
                            @if ($reseller->position == 'Agen')
                                
                            @else
                            <a href="#" data-id="{{ $reseller->id }}" data-resellerid="{{ $reseller->reseller_id }}" data-name="{{ $reseller->name }}" data-toggle="modal" data-target="#editReseller"><i class="fas fa-edit" style="font-size: 70%"></i></a>
                            @endif
                            
                            
                            </td>
                            <td>{{ $reseller->name }}</td>
                            <td>
                                {{ $reseller->sale->sum('quantity') }} <a href="{{ route('admin.member.detailReseller', ['agent'=>$member->id,'reseller'=>$reseller->id]) }}"><i class="fas fa-eye"></i></a>
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

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.member.update') }}" enctype="multipart/form-data" method="POST">
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
                        <label for="resellerid">Id Reseller</label>
                        <input type="text" class="form-control @error('resellerid') is-invalid @enderror" id="resellerid" name="resellerid" required>
                        @error('resellerid')
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

<div class="modal fade bd-example-modal-lg" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.member.saleStore') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="user_id" value="{{ $member->id }}">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Tambah</span> Data Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <i style="font-size: 80%; color:grey">Jika tidak ada perolehan pada Bonus atau Point, silahkan isi dengan angka 0</i>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="reseller_id">Reseller</label>
                                    <select name="reseller_id" id="reseller_id"
                                        class="form-control " required
                                        autocomplete="name" autofocus>
                                        @foreach ($member->reseller as $resellers)
                                        <option value="{{ $resellers->id }}">{{ $resellers->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="product_name">Produk <i style="font-size: 50%; color:red">(Klik Tulisan Produknya)</i></label>
                                <input list="code" name="product_name" id="product_name" autocomplete="off" required class="form-control">
                                    <datalist id="code">
                                        @foreach($products as $product)
                                        <option value="{{ $product->name }}">{{ $product->name }}</option>
                                        @endforeach
                                    </datalist>
                                @error('product_name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" required autocomplete="off">
                                @error('quantity')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="point_earn">Point yg didapat</label>
                                <input type="number" class="form-control @error('point_earn') is-invalid @enderror" id="point_earn" name="point_earn" value="{{ old('point_earn') }}" required autocomplete="off">
                                @error('point_earn')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="bonus_earn">Bonus yg didapat</label>
                                <input type="number" class="form-control @error('bonus_earn') is-invalid @enderror" id="bonus_earn" name="bonus_earn" value="{{ old('bonus_earn') }}" required autocomplete="off">
                                @error('bonus_earn')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="sale_date">Tanggal Penjualan</label>
                                <input type="date" class="form-control @error('sale_date') is-invalid @enderror" id="sale_date" name="sale_date" value="{{ old('sale_date') }}" required autocomplete="off">
                                @error('sale_date')
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

<div class="modal fade bd-example-modal-lg" id="tambahReseller" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.member.addReseller') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="user_id" value="{{ $member->id }}">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Tambah</span> Reseller</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                                <label for="name_reseller">Tim Reseller</label>
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