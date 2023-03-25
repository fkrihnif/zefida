<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Selling;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SellingController extends Controller
{
    public function index(Request $request){
        $current_month = Carbon::now()->month;
        $products = Product::all();
        $users = User::where('role', '!=', 0)->where('is_active', 1)->get();
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        if ($fromDate) {
            $selling = Selling::whereRaw(
                "(sale_date >= ? AND sale_date <= ?)", 
                [
                   $fromDate, 
                   $toDate
                ]
              )->orderBy('id', 'DESC')->get();
            
            $pendapatan = Selling::whereRaw(
                "(sale_date >= ? AND sale_date <= ?)", 
                [
                   $fromDate, 
                   $toDate
                ]
              )->sum('total_price');
        } else {
            $selling = Selling::whereMonth('sale_date', $current_month)->orderBy('id', 'DESC')->get();
            $pendapatan = Selling::whereMonth('sale_date', $current_month)->sum('total_price');
        }
        return view('pages.admin.selling.index', compact('selling', 'products', 'users', 'pendapatan'));
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $selling = new Selling();
            $selling->user_id = $request->get('name');

            $product_id = Product::where('name', $request->get('product_name'))->first()->id;
            $product_price = Product::where('name', $request->get('product_name'))->first()->price;
            $selling->product_id = $product_id;
            $selling->quantity = $request->get('quantity');

            //cek apakah produk itu paket atau eceran
            $is_package = Product::where('id', $product_id)->first()->is_package;
            if ($is_package == 1) {
                $selling->package_earn = $request->get('quantity');   
            } else {
                $selling->package_earn = 0;
            }
            $selling->sale_date = $request->get('sale_date');
            $selling->bonus_earn = $request->get('bonus_earn');
            $selling->total_price = $request->get('quantity') * $product_price;
            $selling->save();

            //cek status user, apakah agent atau masih reseller
            $cek = User::where('id', $request->get('name'))->first()->role;
            if ($cek == 1) {
                //kalau dia reseller (1), maka :
                $total_penjualan_paket = Selling::where('user_id', $request->get('name'))->sum('package_earn');
                if ($total_penjualan_paket >= 6 ) {
                    //kalau total penjualan paket sudah 6, maka naik menjadi agen
                    $change_role = User::findOrFail($request->get('name'));
                    $change_role->role = '2';
                    $change_role->update();
                }
            }
            DB::commit();
            toast('Data Penjualan Berhasil Ditambah','success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toast('Data Penjualan Gagal Disimpan','error');
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
            $selling = Selling::find($request->id);
    
            $selling->delete();

            toast('Data Berhasil Dihapus','success');
            return redirect()->back();
    }
}
