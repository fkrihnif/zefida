<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reseller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index(){
        $members = User::where('role', '1')->orderBy('id', 'DESC')->get();
        return view('pages.admin.member.index', compact('members'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'password' => 'required|min:8'
            ]);
            $member = new User();
            $member->name = $request->get('name');
            $member->username = $request->get('username');
            $member->password = Hash::make($request->get('password'));
            $member->role = '1';
            $member->agent_id = $request->get('agent_id');
            $member->save();
           
            for($i = 0; $i < count($request->name_reseller); $i++){
                if($request->name_reseller[0] != null) {
                    Reseller::create([
                        'user_id' => $member->id,
                        'name' => $request->name_reseller[$i],
                        'point' => '0'
                    ]);
                }
            } 
            DB::commit();
            toast('Data Berhasil Disimpan','success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toast('Gagal menambah data pembelian')->autoClose(2000)->hideCloseButton();
            return redirect()->back();
        }
       
    }
}
