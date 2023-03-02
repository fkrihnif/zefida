<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reseller;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $reseller = Reseller::where('user_id', Auth::user()->id)->count();
        $sell_item = Sale::where('user_id', Auth::user()->id)->sum('quantity');
        return view('pages.member.dashboard.index', compact('reseller', 'sell_item'));
    }
}
