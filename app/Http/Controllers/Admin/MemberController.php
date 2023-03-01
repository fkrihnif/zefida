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
                'password' => 'required|min:8'
            ]);
            $member = new User();
            $member->name = $request->get('name');
            $member->username = $request->get('username');
            $member->password = Hash::make($request->get('password'));
            $member->role = '1';
            $member->agent_id = $request->get('agent_id');
            $member->save();

            //untuk ketua reseller (Si member tersebut)
            $string = ' (Ketua)';
            $reseller_main = new Reseller();
            $reseller_main->user_id = $member->id;
            $reseller_main->name = $request->get('name').$string;
            $reseller_main->point = '0';
            $reseller_main->save();

            //untuk anak buahnya (tim resellernya)
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
            toast('Data Gagal Disimpan','error');
            return redirect()->back();
        }
    }

    public function show ($id){
        $member = User::find($id);
        return view('pages.admin.member.detail', compact('member'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required||unique:users,username,'.$request->id,
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

    public function delete(Request $request){
        $member = User::find($request->id);
        $member->delete();
        toast('Data Berhasil Dihapus','success');
        return redirect()->back();
    }
}
