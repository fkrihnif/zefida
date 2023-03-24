<?php

namespace App\Http\Controllers\Reseller;

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

class ResellerController extends Controller
{
    public function index(Request $request)
    {
        $reseller = User::find(Auth::user()->id);

        $nama = "Reseller";
        
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

        return view('pages.reseller.reseller.index', compact('reseller' ,'sales3', 'nama'));
    }
}
