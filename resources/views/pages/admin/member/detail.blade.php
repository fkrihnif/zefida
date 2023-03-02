@extends('layouts.admin')

<style>
    img {
    max-width: 100%;
    height: auto;
    }

    .item {
        width: 120px;
        height: 120px;
        height: auto;
        float: left;
        margin: 3px;
        padding: 3px;
    }
    #myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
    }

    #myImg:hover {opacity: 0.7;}


    #myImg2 {

    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
    }

    #myImg2:hover {opacity: 0.7;}

    /* The Modal (background) */
    .modal-image {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content-image {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
    }

    /* Add Animation */
    .modal-content-image, #caption {  
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
    }

    @keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
    }

    /* The Close Button */
    .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    transition: 0.1s;
    }

    .close:hover,
    .close:focus {
    color: white;
    text-decoration: none;
    cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px){
    .modal-content-image {
    width: 100%;
    }
}
</style>

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Member</h1>
    </div>
    <a href="{{ route('admin.member.index') }}"><i class="fas fa-arrow-left" style="font-size: 85%"> Kembali</i></a>


    <div class="card shadow mb-4 mt-2">
        <div class="card-body">
           <div class="row">
            <div class="col-4"><b>Id_Agen</b></div>
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
           <div class="row">
            <div class="col-4"><b>Total Point</b></div>
            <div class="col-8">: {{ $member->total_point }}</div>
           </div>
           <hr>
           <div class="row">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h1 class="h3 mb-0 text-gray-800">Tim Reseller</h1>
                        <a href="#" data-toggle="modal" data-target="#tambahReseller"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah Reseller</i></a>
                        </a>
                    </div>
                </div>

                <div class="col-12 ml-2">
                    <div class="row">
                        @foreach ($member->reseller as $reseller)
                        <div class="col-6">
                            - {{ $reseller->name }} - ({{$reseller->point}}) &nbsp; <a href="#" data-id="{{ $reseller->id }}" data-name="{{ $reseller->name }}" data-point="{{ $reseller->point }}" data-toggle="modal" data-target="#editReseller"><i class="fas fa-edit" style="font-size: 75%"></i></a>
                        </div>    
                        @endforeach
                    </div>    
                </div>
           </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Detail Penjualan Reseller</h1>
                <a href="#" data-toggle="modal" data-target="#tambah"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah Penjualan</i></a>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Reseller</th>
                            <th>Produk</th>
                            <th>Quantity</th>
                            <th>Point</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        <?php
                        $i = 1;
                        ?>
                        @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $sale->reseller->name }}</td>
                            <td> 
                                <div class="item">
                                    <img style="height:50px"  id="myImg" class="img-fluid" src="{{ Storage::url($sale->product->image) }}">
                                 </div> <br>
                                 {{ $sale->product->name }}
                                </td>
                            <td>{{ $sale->quantity }}</td>
                            <td>{{ $sale->point_earn }}</td>
                            <td>{{ date('d-m-Y', strtotime($sale->sale_date)) }}</td>
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

<!-- The Modal -->
<div id="myModal" class="modal-image">
    <span class="close">&times;</span>
    <img id="modal-img" class="modal-content-image" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQS2ol73JZj6-IqypxPZXYS3rRiPwKteoD8vezk9QsRdkjt3jEn&usqp=CAU">
    <div id="caption"></div>
</div>

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
                    <div class="form-group">
                        <label for="total_point">Total Point</label>
                        <input type="number" class="form-control @error('total_point') is-invalid @enderror" id="total_point" name="totalp" required>
                        @error('total_point')
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
                        <div class="col-6">
                            <div class="form-group ml-3">
                                <label for="name_reseller">Tim Reseller</label>
                                <input type="text" class="form-control @error('name_reseller') is-invalid @enderror" id="name_reseller" name="name_reseller[]" value="{{ old('name_reseller') }}" autocomplete="off">
                                @error('name_reseller')
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
            var totalp = $(e.relatedTarget).data('totalp');
            $('#edit').find('input[name="id"]').val(id);
            $('#edit').find('input[name="name"]').val(name);
            $('#edit').find('input[name="username"]').val(username);
            $('#edit').find('input[name="agent"]').val(agent);
            $('#edit').find('input[name="totalp"]').val(totalp);
        });

        $("#editReseller").on('show.bs.modal', (e) => {
            var id = $(e.relatedTarget).data('id');
            var name = $(e.relatedTarget).data('name');
            var point = $(e.relatedTarget).data('point');
            $('#editReseller').find('input[name="id"]').val(id);
            $('#editReseller').find('input[name="name"]').val(name);
            $('#editReseller').find('input[name="point"]').val(point);
        });

         // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        // var img = document.getElementById("myImg");
        var modalImg = document.getElementById("modal-img");
        var captionText = document.getElementById("caption");
        // img.onclick = function(){
        //   modal.style.display = "block";
        //   modalImg.src = this.src;
        //   captionText.innerHTML = this.alt;
        // }


        document.addEventListener("click", (e) => {
        const elem = e.target;
        if (elem.id==="myImg") {
            modal.style.display = "block";
            modalImg.src = elem.dataset.biggerSrc || elem.src;
            captionText.innerHTML = elem.alt; 
        }
        })

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
        modal.style.display = "none";
        }


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
                            <div class="col-6">
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