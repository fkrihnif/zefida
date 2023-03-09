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

    <div class="card shadow mb-4 mt-2">
        <div class="card-body">
           <div class="row">
            <div class="col-4"><b>Id_Agen</b></div>
            <div class="col-6">: {{ $member->agent_id }}</div>
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
                    </div>
                </div>

                <div class="col-12 ml-2">
                    <div class="row">
                        @foreach ($member->reseller as $reseller)
                        <div class="col-6">
                            - {{ $reseller->name }} - ({{$reseller->point}})
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