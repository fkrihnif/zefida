<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentReseller;
use App\Models\User;
use App\Models\Product;
use App\Models\Selling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimController extends Controller
{
    public function index(){
        $agents = User::where('role', '2')->where('is_active', '1')->orderBy('id', 'DESC')->get();
        return view('pages.admin.tim.index', compact('agents'));
    }

    public function storeAgent(Request $request)
    {
            $validatedData = $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'id' => 'required|unique:users,identity_id',
            ]);
            $agent = new User();
            $agent->name = $request->get('name');
            $agent->username = $request->get('username');
            $agent->password = Hash::make('password123');
            $agent->role = '2';
            $agent->identity_id = $request->get('id');
            $agent->is_active = 1;
            $agent->save();
        
            toast('Data Agent Berhasil Disimpan','success');
            return redirect()->back();
    }

    public function detail (Request $request, $id){
        $agent = User::find($id);

        $total_penjualan_pribadi_tahun = User::where('id', $agent->id)->with('selling', function ($query) {
            $current_year = Carbon::now()->year;
            $query->whereYear('sale_date', $current_year);
            })->get();

        $total_penjualan_tim_tahun = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) {
            $current_year = Carbon::now()->year;
            $query->whereYear('sale_date', $current_year);
            })->get();
        
        
        $total_penjualan_tim_bulan = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();

        $bonus_bulan = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();

        return view('pages.admin.tim.detail', compact('agent', 'total_penjualan_pribadi_tahun', 'total_penjualan_tim_tahun', 'total_penjualan_tim_bulan', 'bonus_bulan'));
    }

    public function storeReseller(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'name_reseller' => 'required',
                'username_reseller' => 'required|unique:users,username',
                'reseller_id' => 'required|unique:users,identity_id',
            ]);
            $reseller = new User();
            $reseller->name = $request->get('name_reseller');
            $reseller->username = $request->get('username_reseller');
            $reseller->password = Hash::make('password123');
            $reseller->role = '1';
            $reseller->is_active = 1;
            $reseller->identity_id = $request->get('reseller_id');
            $reseller->save();

            $tim = new AgentReseller();
            $tim->user_agent_id = $request->get('agent_id');
            $tim->user_reseller_id = $reseller->id;
            $tim->save();
            DB::commit();
            toast('Data Berhasil Disimpan','success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toast('Data Gagal Disimpan','error');
            return redirect()->back();
        }
    }

    public function updateAgent(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'agent' => 'required||unique:users,identity_id,'.$request->id,
        ]);
        $agent = User::find($request->id);
        $agent->name = $request->get('name');
        $agent->identity_id = $request->get('agent');
        $agent->save();
        toast('Data Agen Berhasil Diubah','success');
        return redirect()->back();
    }

    public function updateReseller(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'resellerid' => 'required||unique:users,identity_id,'.$request->id,
        ]);
        $reseller = User::find($request->id);
        $reseller->name = $request->get('name');
        $reseller->identity_id = $request->get('resellerid');
        $reseller->is_active = $request->get('isactive');
        $reseller->save();
        toast('Data Reseller Berhasil Diubah','success');
        return redirect()->back();
    }

    public function detailReseller (Request $request, $agent, $reseller){
        $agent = User::find($agent);

        $reseller = User::find($reseller);

        if ($agent->id == $reseller->id) {
            $nama = "Agent";
        } else {
            $nama = "Reseller";
        }

        $total_penjualan_pribadi_tahun = User::where('id', $agent->id)->with('selling', function ($query) {
            $current_year = Carbon::now()->year;
            $query->whereYear('sale_date', $current_year);
            })->get();

        $total_penjualan_tim_tahun = AgentReseller::where('user_agent_id', $agent->id)->with('selling', function ($query) {
            $current_year = Carbon::now()->year;
            $query->whereYear('sale_date', $current_year);
            })->get();
        
        
        $total_penjualan_reseller_bulan = User::where('id', $reseller->id)->with('selling', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();

        $bonus_bulan = User::where('id', $reseller->id)->with('selling', function ($query) {
            $current_month = Carbon::now()->month;
            $query->whereMonth('sale_date', $current_month);
            })->get();
        
        $current_month = Carbon::now()->month;

        $request_month = $request->get('search_month');
        $get_month = substr($request_month, 5);

        if ($request_month) {
            $sales3 = Selling::where('user_id', $reseller->id)->whereMonth('sale_date', $get_month)
            ->orderBy('sale_date')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->sale_date)->format('d M Y');
            });
        } else {
            $sales3 = Selling::where('user_id', $reseller->id)->whereMonth('sale_date', $current_month)
            ->orderBy('sale_date')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->sale_date)->format('d M Y');
            });
        }

        return view('pages.admin.tim.detail-reseller', compact('reseller' ,'agent' ,'sales3', 'total_penjualan_pribadi_tahun', 'total_penjualan_tim_tahun', 'total_penjualan_reseller_bulan', 'bonus_bulan', 'nama'));
    }

    public function delete(Request $request)
    {
        $tim = AgentReseller::where('user_agent_id', $request->id);
        $tim->delete();
        toast('Tim Berhasil Dihapus','success');
        return redirect()->back();
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
