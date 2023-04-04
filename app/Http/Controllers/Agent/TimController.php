<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentReseller;
use App\Models\User;
use App\Models\Product;
use App\Models\Selling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TimController extends Controller
{
    public function index(Request $request)
    {
        $agent = User::find(Auth::user()->id);

        $request_month = $request->get('search_month');

        if ($request_month) {
            $reseller = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) use ($request_month) {
                $get_month = substr($request_month, 5);
                $query->whereMonth('sale_date', $get_month);
                })->get();
        } else {
            $reseller = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) {
                $current_month = Carbon::now()->month;
                $query->whereMonth('sale_date', $current_month);
                })->get();
        }

        $total_penjualan_pribadi_bulan = User::where('id', $agent->id)->with('selling', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();

        $total_penjualan_pribadi_tahun = User::where('id', $agent->id)->with('selling', function ($query) {
            $current_year = Carbon::now()->year;
            $query->whereYear('sale_date', $current_year);
            })->get();

        $total_penjualan_tim_tahun = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) {
            $current_year = Carbon::now()->year;
            $query->whereYear('sale_date', $current_year);
            })->get();
        
        
        $total_penjualan_tim_bulan = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();

        $bonus_bulan = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();

        return view('pages.agent.tim.index', compact('agent', 'reseller', 'total_penjualan_pribadi_bulan', 'total_penjualan_pribadi_tahun', 'total_penjualan_tim_tahun', 'total_penjualan_tim_bulan', 'bonus_bulan'));
    }

    public function detailSelling(Request $request, $id){
        $agent = User::find($id);
        $current_month = Carbon::now()->month;
        $request_month = $request->get('search_month');
        if ($request_month) {
            $selling = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) use ($request_month) {
                $get_month = substr($request_month, 5);
                $query->whereMonth('sale_date', $get_month);
                })->get();

            $bonus = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) use ($request_month) {
                $get_month = substr($request_month, 5);
                $query->whereMonth('sale_date', $get_month);
                })->get();

        } else {
            $selling = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) {
                $current_month = Carbon::now()->month;
                $query->whereMonth('sale_date', $current_month);
                })->get();

            $bonus = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) {
                $current_month = Carbon::now()->month;
                $query->whereMonth('sale_date', $current_month);
                })->get();
        }

        return view('pages.agent.tim.detail-selling', compact('agent','selling', 'bonus'));
    }

    public function detailReseller(Request $request, $agent, $reseller) 
    {
        $agent = User::find($agent);

        $reseller = User::find($reseller);

        if ($agent->id == $reseller->id) {
            $nama = "Agent";
        } else {
            $nama = "Reseller";
        }

        $total_penjualan_pribadi_tahun = User::where('id', $agent->id)->with('selling', function ($query) {
            $current_year = Carbon::now()->year;
            $query->whereYear('sale_date', $current_year);
            })->get();

        $total_penjualan_tim_tahun = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) {
            $current_year = Carbon::now()->year;
            $query->whereYear('sale_date', $current_year);
            })->get();
        
        
        $total_penjualan_reseller_bulan = User::where('id', $reseller->id)->with('selling', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();

        $bonus_bulan = User::where('id', $reseller->id)->with('selling', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();
        
        $current_month = Carbon::now()->month;

        $request_month = $request->get('search_month');
        $get_month = substr($request_month, 5);

        if ($request_month) {
            $sales3 = Selling::where('user_id', $reseller->id)->whereMonth('sale_date', $get_month)
            ->orderBy('sale_date')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->sale_date)->format('d M Y');
            });
        } else {
            $sales3 = Selling::where('user_id', $reseller->id)->whereMonth('sale_date', $current_month)
            ->orderBy('sale_date')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->sale_date)->format('d M Y');
            });
        }

        return view('pages.agent.tim.detail-reseller', compact('reseller' ,'agent' ,'sales3', 'total_penjualan_pribadi_tahun', 'total_penjualan_tim_tahun', 'total_penjualan_reseller_bulan', 'bonus_bulan', 'nama'));
    }
}
