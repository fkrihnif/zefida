<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Reseller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ResellerController extends Controller
{
    public function index (Request $request){
        $member = User::find(Auth::user()->id);

        $total_penjualan_pribadi_tahun = Reseller::where('user_id', Auth::user()->id)->where('position', 'Agen')->with('sale', function ($query) {
            $current_year = Carbon::now()->year;
            $query->whereYear('sale_date', $current_year);
            })->get();
        
        $total_penjualan_tim_tahun = Reseller::where('user_id', Auth::user()->id)->with('sale', function ($query) {
            $current_year = Carbon::now()->year;
            $query->whereYear('sale_date', $current_year);
            })->get();
        
        $total_penjualan_tim_bulan = Reseller::where('user_id', Auth::user()->id)->with('sale', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();

        $bonus_bulan = Reseller::where('user_id', Auth::user()->id)->with('sale', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();

        $request_month = $request->get('search_month');

        if ($request_month) {
            $resellers = Reseller::where('user_id', Auth::user()->id)->with('sale', function ($query) use ($request_month) {
                $get_month = substr($request_month, 5);
                $query->whereMonth('sale_date', $get_month);
                })->get();
        } else {
            $resellers = Reseller::where('user_id', Auth::user()->id)->with('sale', function ($query) {
                $current_month = Carbon::now()->month;
                $query->whereMonth('sale_date', $current_month);
                })->get();
        }

        return view('pages.member.reseller.index', compact('member', 'resellers', 'total_penjualan_pribadi_tahun', 'total_penjualan_tim_tahun', 'total_penjualan_tim_bulan', 'bonus_bulan'));
    }

    public function detailReseller (Request $request, $agent, $reseller){
        $member = User::find($agent);

        $reseller = Reseller::find($reseller);

        $total_penjualan_pribadi_tahun = Reseller::where('user_id', $agent)->where('position', 'Agen')->with('sale', function ($query) {
            $current_year = Carbon::now()->year;
            $query->whereYear('sale_date', $current_year);
            })->get();
        
        $total_penjualan_tim_tahun = Reseller::where('user_id', $agent)->with('sale', function ($query) {
            $current_year = Carbon::now()->year;
            $query->whereYear('sale_date', $current_year);
            })->get();
        
        $total_penjualan_reseller_bulan = Reseller::where('id', $reseller->id)->with('sale', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();

        $bonus_bulan = Reseller::where('id', $reseller->id)->with('sale', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();
        
        $current_month = Carbon::now()->month;

        $request_month = $request->get('search_month');
        $get_month = substr($request_month, 5);

        if ($request_month) {
            $sales3 = Sale::where('reseller_id', $reseller->id)->whereMonth('sale_date', $get_month)
            ->orderBy('sale_date')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->sale_date)->format('d M Y');
            });
        } else {
            $sales3 = Sale::where('reseller_id', $reseller->id)->whereMonth('sale_date', $current_month)
            ->orderBy('sale_date')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->sale_date)->format('d M Y');
            });
        }

        return view('pages.member.reseller.detail-reseller', compact('reseller' ,'member' ,'sales3', 'total_penjualan_pribadi_tahun', 'total_penjualan_tim_tahun', 'total_penjualan_reseller_bulan', 'bonus_bulan'));
    }
}
