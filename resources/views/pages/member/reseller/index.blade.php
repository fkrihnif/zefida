@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Tim</h1>
    </a>
    </div>


    <div class="card shadow mb-4 mt-2">
        <div class="card-body" style="background-color: #f5f6fa">
           <div class="row">
            <div class="col-4"><b>Id No</b></div>
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
        <div class="card-body" style="background-color: #f5f6fa">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Penjualan Reseller</h1>
            </div>
            <form action="{{ route('member.reseller.index') }}">
                <div class="row mt-2">
                        <div class="col-4">
                            <input type="month" id="search_month" name="search_month"
                            min="2023-01" value="{{Request::get('search_month')}}">
                            <input type="submit" value="Cari" class="btn btn-primary text-white ml-3">
                        </div>
                </div>
            </form>
            <form action="{{ route('member.reseller.index') }}">
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
                            </td>
                            <td>{{ $reseller->name }}</td>
                            <td>
                                {{ $reseller->sale->sum('quantity') }} <a href="{{ route('member.reseller.detailReseller', ['agent'=>$member->id,'reseller'=>$reseller->id]) }}"><i class="fas fa-eye"></i></a>
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

@endsection
@push('addon-script')

@endpush