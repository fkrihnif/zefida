@extends('layouts.admin')
@push('addon-style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

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
@endpush

@section('content')
<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Penjualan Tim</h1>
    </a>
    </div>
    <a href="{{ route('admin.tim.detail', $agent->id) }}"><i class="fas fa-arrow-left mb-3" style="font-size: 85%"> Kembali</i></a>

    <div class="card shadow mb-4">
        <div class="card-body" style="background-color: #f5f6fa">
            <i style="font-size: 80%"><u>Secara default menampilkan penjualan bulan ini, silahkan filter bulan untuk pencarian</u></i>

                <form action="{{ route('admin.tim.detailSelling', $agent->id) }}">
                    <div class="row mt-2">
                            <div class="col-4">
                                <input type="month" id="search_month" name="search_month"
                                min="2023-01" value="{{Request::get('search_month')}}">
                                <input type="submit" value="Cari" class="btn btn-primary text-white btn-sm">
                            </div>
                    </div>
                </form>
                <form action="{{ route('admin.tim.detailSelling', $agent->id) }}">
                    <input type="submit" value="Lihat Bulan Ini" class="btn btn-warning btn-sm text-white mt-2">
                </form>
            
            @php
            $c = [];
            @endphp
            @foreach ($bonus as $b)
            @php
            $c[] = $b->selling->sum('bonus_earn') ;
            @endphp
            @endforeach
            @php
            $totalC = array_sum($c);
            @endphp

            @if (Request::get('to_date'))
            <p>Total Bonus dari Tanggal <br>{{ date('d M Y', strtotime(Request::get('from_date'))) }} sampai {{ date('d M Y', strtotime(Request::get('to_date'))) }} =<b> @currency($totalC)</b></p>
            @else
            <p>Total Bonus Bulan ini :<b> @currency($totalC)</b></p>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Id - Nama</th>
                            <th>Produk</th>
                            <th>Quantity</th>
                            <th>Bonus</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $i = 1;
                        ?>
                        @foreach ($selling as $s)
                            @foreach ($s->selling as $item)
                            <tr>
                                <td>{{ date('d-m-Y', strtotime($item->sale_date)) }}</td>
                                <td>{{ $item->user->identity_id }} <hr> {{ $item->user->name }}</td>
                                <td> 
                                <div class="item">
                                    <img style="height:50px"  id="myImg" class="img-fluid" src="{{ Storage::url($item->product->image) }}">
                                </div> <br><br><br>
                                {{ $item->product->name }}
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>@currency($item->bonus_earn)</td>
                            </tr>
                            @endforeach
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


@endsection
@push('addon-script')

<script>

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