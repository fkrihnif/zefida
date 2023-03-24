@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-0 text-gray-800">Detail Tim</h1>
    </a>
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
            <div class="col-8">: {{ $agent->selling->sum('package_earn') }} Paket <a href="{{ route('agent.tim.detailReseller', ['agent'=>$agent->id,'reseller'=>$agent->id]) }}"><i class="fas fa-eye"></i></a></div>
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
                </a>
            </div>
            <form action="{{ route('agent.tim.index') }}">
                <div class="row mt-2">
                        <div class="col-4">
                            <input type="month" id="search_month" name="search_month"
                            min="2023-01" value="{{Request::get('search_month')}}">
                            <input type="submit" value="Cari" class="btn btn-primary text-white ml-3">
                        </div>
                </div>
            </form>
            <form action="{{ route('agent.tim.index') }}">
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
                            <td>{{ $r->user->identity_id }} </td>
                            <td>{{ $r->user->name }}</td>
                            <td>{{ $r->user->selling->sum('package_earn') }} <a href="{{ route('agent.tim.detailReseller', ['agent'=>$agent->id,'reseller'=>$r->user->id]) }}"><i class="fas fa-eye"></i></a></</td>
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


@endsection
