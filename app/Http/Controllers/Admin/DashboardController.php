<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reseller;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $member = User::where('role', 1)->count();
        $reseller = Reseller::count();
        $product = Product::count();
        $current_year = Carbon::now()->year;
        $sell_item = Sale::whereYear('sale_date', $current_year)->sum('quantity');


        return view('pages.admin.dashboard.index', compact('member', 'reseller', 'product', 'sell_item'));
    }
}
