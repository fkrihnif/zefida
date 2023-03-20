<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Selling;
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
            $reseller = User::where('role', 1)->count();
            $agent = User::where('role', 2)->count();
            $product = Product::count();
            $sell_item = Selling::sum('quantity');
            return view('pages.admin.dashboard.index', compact('agent', 'reseller', 'product', 'sell_item'));
        } else if(auth()->user()->role == '1') {
            // $reseller = Reseller::where('user_id', Auth::user()->id)->count();
            // $sell_item = Sale::where('user_id', Auth::user()->id)->sum('quantity');
            return view('pages.member.dashboard.index');
        }
    }
}
