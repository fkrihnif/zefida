<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reseller;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;


class DashboardController extends Controller
{
    public function index(){
        $member = User::where('role', 1)->count();
        $reseller = Reseller::count();
        $product = Product::count();
        $sell_item = Sale::sum('quantity');


        return view('pages.admin.dashboard.index', compact('member', 'reseller', 'product', 'sell_item'));
    }
}
