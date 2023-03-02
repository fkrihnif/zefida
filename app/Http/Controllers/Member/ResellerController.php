<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class ResellerController extends Controller
{
    public function index()
    {
        $member = User::find(Auth::user()->id);
        $products = Product::orderBy('id', 'DESC')->get();
        $sales = Sale::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('pages.member.reseller.index', compact('member', 'products', 'sales'));
    }
}
