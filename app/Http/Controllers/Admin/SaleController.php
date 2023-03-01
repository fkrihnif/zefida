<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(){
        $sales = Sale::orderBy('id', 'DESC')->get();
        $members = User::with('reseller')->where('role', '1')->orderBy('id', 'DESC')->get();
        $products = Product::orderBy('id', 'DESC')->get();
        return view('pages.admin.sale.index', compact('sales', 'members', 'products'));
    }
}
