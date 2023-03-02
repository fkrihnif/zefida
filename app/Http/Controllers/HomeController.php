<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reseller;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->role == '0'){
            $member = User::where('role', 1)->count();
            $reseller = Reseller::count();
            $product = Product::count();
            $sell_item = Sale::sum('quantity');
            return view('pages.admin.dashboard.index', compact('member', 'reseller', 'product', 'sell_item'));
        } else {
            $reseller = Reseller::where('user_id', Auth::user()->id)->count();
            $sell_item = Sale::where('user_id', Auth::user()->id)->sum('quantity');
            return view('pages.member.dashboard.index', compact('reseller', 'sell_item'));
        }
    }
}
