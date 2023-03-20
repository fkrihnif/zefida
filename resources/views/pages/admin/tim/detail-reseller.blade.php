@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Reseller</h1>
    </a>
    </div>
    <a href="{{ route('admin.tim.detail', $agent->id) }}"><i class="fas fa-arrow-left" style="font-size: 85%"> Kembali</i></a>


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
           <div class="row justify-content-end">
            <div class="col-6" style="border: 1px solid black;">
              Total Penjualan Pribadi (paket) (th 2023)
            </div>
            <div class="col-3" style="border: 1px solid black;">
                 @foreach ($total_penjualan_pribadi_tahun as $tpp)
                 {{ $tpp->selling->sum('package_earn') }}
                 @endforeach
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-6" style="border: 1px solid black;">
              Total Penjualan Tim (paket) (th 2023)
            </div>
            <div class="col-3" style="border: 1px solid black;">
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
                {{ $totalPurchase }}
            </div>
          </div>
          <br>
          <div class="row justify-content-end">
            <div class="col-6" style="border: 1px solid black;">
              Total Penjualan (paket)<b>{{ $reseller->name }}</b>
            </div>
            <div class="col-3" style="border: 1px solid black;">
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
                {{ $totalPurchaseBulan }}
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-6" style="border: 1px solid black;">
              Bonus Anda
            </div>
            <div class="col-3" style="border: 1px solid black;">
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
                @currency($totalC)
            </div>
          </div>
          
          <hr>
          <div class="row">
            <div class="col-12">Total Penjualan Pribadi {{ \Carbon\Carbon::now()->year }} = <b>
                @foreach ($total_penjualan_pribadi_tahun as $tpp)
                {{ $tpp->selling->sum('package_earn') }} Paket
                @endforeach  </b>
            </div>
            <div class="col-12">
                Total Penjualan Tim {{ \Carbon\Carbon::now()->year }} = <b>
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
                    {{ $totalPurchase }} Paket
                </b>
            </div>
            <div class="col-12">
                Total Penjualan bulanan {{ $reseller->name }} = <b>
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
                    {{ $totalPurchaseBulan }} Paket
                </b>
            </div>
            <div class="col-12">
                Bonus Anda = <b>
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
                    @currency($totalC)
                </b>
            </div>
        </div>
                <table border="1">
                    <tbody>
                    <tr><td>Total Penjualan Pribadi {{ \Carbon\Carbon::now()->year }}</td><td>Bang Johnes</td></tr>
                    <tr><td>Total Penjualan Tim {{ \Carbon\Carbon::now()->year }}</td><td>Blogger</td></tr>
                    <tr><td>tal Penjualan bulanan {{ $reseller->name }}</td><td>Blogger</td></tr>
                    <tr><td>Bonus Anda</td><td>Blogger</td></tr>
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
                <input type="submit" value="Lihat Bulan Ini" class="btn btn-warning btn-sm text-white">
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tgl</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Paket</th>
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
                                    <td>{{ $item->package_earn }}</td>
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