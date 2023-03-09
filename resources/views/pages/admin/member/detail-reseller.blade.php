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
        <h1 class="h3 mb-0 text-gray-800">Detail Tim</h1>
        <a href="#" data-toggle="modal" data-target="#tambahReseller"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah Reseller</i></a>
    </a>
    </div>
    <a href="{{ route('admin.member.detail', $member->id) }}"><i class="fas fa-arrow-left" style="font-size: 85%"> Kembali</i></a>


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
              Total Penjualan {{ $reseller->name }}
            </div>
            <div class="col-3" style="border: 1px solid black;">
                @php
                $tp_tim_bulan = [];
                @endphp
                @foreach ($total_penjualan_reseller_bulan as $tpt_bulan)
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
                {{ $totalC }}
            </div>
          </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <p>{{ $reseller->reseller_id }} - {{ $reseller->name }}</p>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tgl</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Poin</th>
                            <th>Bonus</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach ($sales3 as $days => $day)
                        <tr>
                            <td colspan="5"><b>{{ $days }}</b></td>
                        </tr>
                            @foreach ($day as $item)
                        <tr>
                            <td>{{ $loop->count }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->point_earn }}</td>
                                <td>{{ $item->bonus_earn }}</td>  
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