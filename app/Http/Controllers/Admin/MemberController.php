<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reseller;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function index(){
        $members = User::with('reseller')->where('role', '1')->orderBy('id', 'DESC')->get();
        return view('pages.admin.member.index', compact('members'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'password' => 'required|min:8',
                'agent_id' => 'required|unique:users,agent_id',
            ]);
            $member = new User();
            $member->name = $request->get('name');
            $member->username = $request->get('username');
            $member->password = Hash::make($request->get('password'));
            $member->role = '1';
            $member->agent_id = $request->get('agent_id');
            $member->total_point = '0';
            $member->save();

            //untuk ketua reseller (Si member tersebut)
            $string = ' (A)';
            $reseller_main = new Reseller();
            $reseller_main->user_id = $member->id;
            $reseller_main->name = $request->get('name').$string;
            $reseller_main->reseller_id = $request->get('agent_id');
            $reseller_main->point = '0';
            $reseller_main->position = 'Agen';
            $reseller_main->save();

            //untuk anak buahnya (tim resellernya)
            for($i = 0; $i < count($request->name_reseller); $i++){
                if($request->name_reseller[0] != null) {
                    Reseller::create([
                        'user_id' => $member->id,
                        'name' => $request->name_reseller[$i],
                        'reseller_id' => $request->reseller_id[$i],
                        'point' => '0',
                        'position' => 'Reseller'
                    ]);
                }
            } 
            DB::commit();
            toast('Data Berhasil Disimpan','success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toast('Data Gagal Disimpan','error');
            return redirect()->back();
        }
    }

    public function detail ($id){
        $member = User::find($id);
        $products = Product::orderBy('id', 'DESC')->get();
        $sales = Sale::where('user_id', $id)->orderBy('id', 'DESC')->get();

        $total_penjualan_pribadi_tahun = Reseller::where('user_id', $id)->where('position', 'Agen')->with('sale', function ($query) {
            $query->whereYear('sale_date', '2023');
            })->get();
        
        $total_penjualan_tim_tahun = Reseller::where('user_id', $id)->with('sale', function ($query) {
            $query->whereYear('sale_date', '2023');
            })->get();
        
        $total_penjualan_tim_bulan = Reseller::where('user_id', $id)->with('sale', function ($query) {
            $query->whereMonth('sale_date', '3');
            })->get();

        $bonus_bulan = Reseller::where('user_id', $id)->with('sale', function ($query) {
            $query->whereMonth('sale_date', '3');
            })->get();

        $resellers = Reseller::where('user_id', $id)->with('sale', function ($query) {
            $query->whereMonth('sale_date', '3');
            })->get();

        return view('pages.admin.member.detail', compact('member', 'products', 'sales', 'resellers', 'total_penjualan_pribadi_tahun', 'total_penjualan_tim_tahun', 'total_penjualan_tim_bulan', 'bonus_bulan'));
    }

    public function detailReseller ($agent, $reseller){
        $member = User::find($agent);

        $reseller = Reseller::find($reseller);

        $total_penjualan_pribadi_tahun = Reseller::where('user_id', $agent)->where('position', 'Agen')->with('sale', function ($query) {
            $query->whereYear('sale_date', '2023');
            })->get();
        
        $total_penjualan_tim_tahun = Reseller::where('user_id', $agent)->with('sale', function ($query) {
            $query->whereYear('sale_date', '2023');
            })->get();
        
        $total_penjualan_reseller_bulan = Reseller::where('user_id', $reseller)->with('sale', function ($query) {
            $query->whereMonth('sale_date', '3');
            })->get();

        $bonus_bulan = Reseller::where('user_id', $reseller)->with('sale', function ($query) {
            $query->whereMonth('sale_date', '3');
            })->get();

        $sales = Sale::where('reseller_id', $reseller->id)->whereMonth('sale_date', '3')->get();

        // $sales = Sale::whereMonth('sale_date', '3')
        // ->groupBy(DB::raw('Date(sale_date)'))
        // ->orderBy('sale_date', 'DESC')->get();

        // $sales = Sale::select(
        //     "id" ,
        //     DB::raw("(sum(quantity)) as qty"),
        //     DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as tgl")
        //     )
        //     ->orderBy('created_at')
        //     ->get();

        // $sales = Sale::where('reseller_id', $reseller->id)->where('created_at', '>=', Carbon::now()->subMonth())
        //     ->groupBy('date')
        //     ->orderBy('date', 'DESC')
        //     ->get(array(
        //         DB::raw('Date(created_at) as date'),
        //         DB::raw('sum(quantity) as qty')
        //     ));

        // $sales = Sale::where('reseller_id', $reseller->id)->select('id', 'quantity', 'created_at')
        //     ->get()
        //     ->groupBy(function($date) {
        //         return Carbon::parse($date->created_at)->format('m'); // grouping by mounth
        //     });

        
        // $sales2= Sale::where('reseller_id', $reseller->id)->select('id','quantity', 'created_at')
        // ->get()
        // ->groupBy(function($val) {
        // return Carbon::parse($val->created_at)->format('m');
        // });

        $sales2 = Sale::where('reseller_id', $reseller->id)->orderBy('created_at')->get()->groupBy(function($data) {
            return $data->created_at->format('d');
        });

        $sales3 = Sale::where('reseller_id', $reseller->id)
        ->orderBy('sale_date')
        ->get()
        ->groupBy(function ($val) {
            return Carbon::parse($val->sale_date)->format('d M Y');
        });


        // dd($sales2);


        return view('pages.admin.member.detail-reseller', compact('reseller' ,'member' ,'sales', 'sales2', 'sales3', 'total_penjualan_pribadi_tahun', 'total_penjualan_tim_tahun', 'total_penjualan_reseller_bulan', 'bonus_bulan'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required||unique:users,username,'.$request->id,
            'agent' => 'required||unique:users,agent_id,'.$request->id,
        ]);
        $member = User::find($request->id);
        $member->name = $request->get('name');
        $member->username = $request->get('username');
        $member->agent_id = $request->get('agent');
        $member->save();
        toast('Data Berhasil Diubah','success');
        return redirect()->back();
    }

    public function updateReseller(Request $request)
    {
        $reseller = Reseller::find($request->id);
        $reseller->name = $request->get('name');
        $reseller->point = $request->get('point');
        $reseller->save();
        toast('Data Berhasil Diubah','success');
        return redirect()->back();
    }

    public function addReseller(Request $request)
    {
        DB::beginTransaction();

        try {
            //untuk anak buahnya (tim resellernya)
            for($i = 0; $i < count($request->name_reseller); $i++){
                if($request->name_reseller[0] != null) {
                    Reseller::create([
                        'user_id' => $request->user_id,
                        'name' => $request->name_reseller[$i],
                        'reseller_id' => $request->reseller_id[$i],
                        'point' => '0'
                    ]);
                }
            } 
            DB::commit();
            toast('Data Berhasil Disimpan','success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toast('Data Gagal Disimpan','error');
            return redirect()->back();
        }
    }

    public function delete(Request $request){
        $member = User::find($request->id);
        $member->delete();
        toast('Data Berhasil Dihapus','success');
        return redirect()->back();
    }

    public function saleStore(Request $request)
    {
        DB::beginTransaction();

        try {
            $sale = new Sale();
            $sale->user_id = $request->get('user_id');
            $sale->reseller_id = $request->get('reseller_id');
    
            $product_id = Product::where('name', $request->get('product_name'))->first()->id;
    
            $sale->product_id = $product_id;
            $sale->quantity = $request->get('quantity');
            $sale->point_earn = $request->get('point_earn');
            $sale->sale_date = $request->get('sale_date');
            $sale->bonus_earn = $request->get('bonus_earn');
            $sale->save();
    
            //tambahkan point di data resellernya
            $reseller = Reseller::find($request->reseller_id);
            $point_old = $reseller->point;
            $reseller->point = $point_old + $request->get('point_earn');
            $bonus_old = $reseller->bonus;
            $reseller->bonus = $bonus_old + $request->get('bonus_earn');
            $reseller->save();

            //tambahkan point ke total point punya Member
            $member = User::find($request->user_id);
            $point_old_member = $member->total_point;
            $member->total_point = $point_old_member + $request->get('point_earn');
            $member->save();

            DB::commit();
            toast('Data Berhasil Disimpan','success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toast('Data Gagal Disimpan','error');
            return redirect()->back();
        }
    }

    public function resetPassword(Request $request)
    {
        $pass_random = 'password123';

        $item = User::findOrFail($request->id);
        $item->password = Hash::make($pass_random);
        $item->update();

        toast('Password Berhasil Di Reset!','success');
        return redirect()->back();
    }
}
