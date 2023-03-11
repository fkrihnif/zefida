<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use App\Models\Reseller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(){
        $sales = Sale::orderBy('id', 'DESC')->get();
        return view('pages.admin.sale.index', compact('sales'));
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();

        try {
            $sale = Sale::find($request->id);
    
            //kurangi point, bonus reseller
            $reseller = Reseller::find($sale->reseller_id);
            $point_old = $reseller->point;
            $reseller->point = $point_old - $sale->point_earn;
            $bonus_old = $reseller->bonus;
            $reseller->bonus = $bonus_old - $sale->bonus_earn;
            $reseller->save();
    
            //kurangi total point, bonus member
            $member = User::find($sale->user_id);
            $point_old_member = $member->total_point;
            $member->total_point = $point_old_member - $sale->point_earn;
            $member->save();
    
            $sale->delete();

            DB::commit();
            toast('Data Berhasil Dihapus','success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toast('Data Gagal Dihapus','error');
            return redirect()->back();
        }
    }
}
