<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\AgentReseller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Selling;
use App\Models\Banner;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $sell_item = Selling::where('user_id', Auth::user()->id)->sum('package_earn');
        $banners = Banner::all();
        return view('pages.reseller.dashboard.index', compact('sell_item', 'banners'));
    }
}
