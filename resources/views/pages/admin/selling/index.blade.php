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
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.1s;
    }

    .close:hover,
    .close:focus {
    color: #bbb;
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
        <h1 class="h3 mb-0 text-gray-800">Data Penjualan Per-Bulan</h1>
        <a href="#" data-toggle="modal" data-target="#tambah"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah Penjualan</i></a>
    </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body" style="background-color: #f5f6fa">
            <form action="{{ route('admin.selling.index') }}">
                <div class="row">
                        <div class="col-4">
                            <input type="month" id="search_month" name="search_month"
                            min="2023-01" value="{{Request::get('search_month')}}">
                            <input type="submit" value="Cari" class="btn btn-primary text-white ml-3">
                        </div>
                </div>
            </form>
            <form action="{{ route('admin.selling.index') }}">
                <input type="submit" value="Lihat Bulan Ini" class="btn btn-warning btn-sm text-white">
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id</th>
                            <th>Nama</th>
                            <th>Produk</th>
                            <th>Quantity</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $i = 1;
                        ?>
                        @foreach ($selling as $s)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $s->user->identity_id }}</td>
                            <td>{{ $s->user->name }}</td>
                            <td> 
                            <div class="item">
                                <img style="height:50px"  id="myImg" class="img-fluid" src="{{ Storage::url($s->product->image) }}">
                             </div> <br><br><br>
                             {{ $s->product->name }}
                            </td>
                            <td>{{ $s->quantity }}</td>
                            <td>{{ date('d-m-Y', strtotime($s->sale_date)) }}</td>
                            <td><a href="#" data-target="#delete" data-toggle="modal" data-id="{{ $s->id }}"><i class="fas fa-trash"></i></a>
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
<!-- The Modal -->
<div id="myModal" class="modal-image">
    <span class="close">&times;</span>
    <img id="modal-img" class="modal-content-image" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQS2ol73JZj6-IqypxPZXYS3rRiPwKteoD8vezk9QsRdkjt3jEn&usqp=CAU">
      
    
    <div id="caption"></div>
</div>

<div class="modal fade bd-example-modal-lg" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.selling.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
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
                                <label for="name">ID - Nama</label>
                                    <select name="name" id="name"
                                        class="form-control " required autofocus>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->identity_id }} - {{ $user->name }}</option>
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

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.selling.delete') }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Hapus</span> Data Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus penjualan ini ? <b><i>point, bonus reseller akan dipulihkan</i></b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('addon-script')
<script>

    $('#delete').on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');
        $('#delete').find('input[name="id"]').val(id);
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
</script>

@endpush