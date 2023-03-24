<?php

namespace App\Http\Controllers;

use App\Models\AgentReseller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Selling;
use App\Models\Banner;
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
            $banners = Banner::all();
            return view('pages.admin.dashboard.index', compact('agent', 'reseller', 'product', 'sell_item', 'banners'));

        } else if(auth()->user()->role == '1') {
            $sell_item = Selling::where('user_id', Auth::user()->id)->sum('package_earn');
            $banners = Banner::all();
            return view('pages.reseller.dashboard.index', compact('sell_item', 'banners'));

        } else if(auth()->user()->role == '2') {
            $sell_item = Selling::where('user_id', Auth::user()->id)->sum('package_earn');
            $tim = AgentReseller::where('user_agent_id', Auth::user()->id)->count();
            $banners = Banner::all();
            return view('pages.agent.dashboard.index', compact('sell_item', 'tim', 'banners'));
        }
    }
}
