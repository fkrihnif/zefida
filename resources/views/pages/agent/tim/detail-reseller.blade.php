@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail {{ $nama }}</h1>
    </a>
    </div>
    <a href="{{ route('agent.tim.index') }}"><i class="fas fa-arrow-left" style="font-size: 85%"> Kembali</i></a>


    <div class="card shadow mb-4 mt-2">
        <div class="card-body" style="background-color: #f5f6fa">
           <div class="row">
            <div class="col-4"><b>Id No</b></div>
            <div class="col-6">: {{ $agent->identity_id }}</div>
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
                    @foreach ($total_penjualan_reseller_bulan as $tpt_bulan)
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
                    <tr><td style="padding: 3px;font-size: 90%;">Total Penjualan Bulanan {{ $reseller->name }}</td><td style="padding: 3px; font-size: 90%;text-align:center">{{ $totalPurchaseBulan }} Paket</td></tr>
                    <tr><td style="padding: 3px;font-size: 90%;">Bonus Anda</td><td style="padding: 3px; font-size: 90%;text-align:center"><b>@currency($totalC)</b></td></tr>
                    </tbody>
                </table>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body" style="background-color: #f5f6fa">
            <h4><u>Detail Penjualan</u></h4>
            <b>{{ $reseller->identity_id }} - {{ $reseller->name }}</b>
            <form action="{{ route('admin.tim.detailReseller', ['agent'=>$agent->id,'reseller'=>$reseller->id]) }}">
                <div class="row mt-2">
                        <div class="col-4">
                            <input type="month" id="search_month" name="search_month"
                            min="2023-01" value="{{Request::get('search_month')}}">
                            <input type="submit" value="Cari" class="btn btn-primary text-white ml-3">
                        </div>
                </div>
            </form>
            <form action="{{ route('admin.tim.detailReseller', ['agent'=>$agent->id,'reseller'=>$reseller->id]) }}">
                <input type="submit" value="Lihat Bulan Ini" class="btn btn-warning btn-sm text-white mb-2">
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tgl</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Bonus</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach ($sales3 as $days => $day)
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($day as $key => $item)
                            <tr>    
                                @if ($i == 0)
                                    <td
                                        rowspan="{{ $loop->count }}"
                                     ><b>{{ $days }}</b></td>
                                     @endif
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>@currency($item->bonus_earn)</td>  
                            </tr>
                            @php
                                $i++;
                            @endphp
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


@endsection
@push('addon-script')

@endpush