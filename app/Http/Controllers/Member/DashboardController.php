<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reseller;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $reseller = Reseller::where('user_id', Auth::user()->id)->count();
        $current_year = Carbon::now()->year;
        $sell_item = Sale::where('user_id', Auth::user()->id)->whereYear('sale_date', $current_year)->sum('quantity');
        return view('pages.member.dashboard.index', compact('reseller', 'sell_item'));
    }
}
