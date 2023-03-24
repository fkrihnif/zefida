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

class UserController extends Controller
{
    public function index(){
        $users = User::where('role', '!=', 0)->orderBy('id', 'DESC')->get();
        return view('pages.admin.user.index', compact('users'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'identity_id' => 'required||unique:users,identity_id,'.$request->id,
        ]);
        $user = User::find($request->id);
        $user->name = $request->get('name');
        $user->identity_id = $request->get('identity_id');
        $user->is_active = $request->get('isactive');
        $user->save();
        toast('Data Berhasil Diubah','success');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        toast('User Berhasil Dihapus','success');
        return redirect()->back();
    }
}
