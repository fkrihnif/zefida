<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\Reseller;
use App\Models\User;
use App\Models\Product;
use App\Models\Selling;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $reseller = User::where('role', 1)->count();
        $agent = User::where('role', 2)->count();
        $product = Product::count();
        $current_year = Carbon::now()->year;
        $sell_item = Selling::whereYear('sale_date', $current_year)->sum('quantity');
        $banners = Banner::all();


        return view('pages.admin.dashboard.index', compact('agent', 'reseller', 'product', 'sell_item', 'banners'));
    }
}
