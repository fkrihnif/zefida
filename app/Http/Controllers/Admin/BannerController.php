<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('id', 'DESC')->get();
        return view('pages.admin.banner.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'mimes:JPG,jpeg,png,jpg,SVG,svg|max:3072',
        ]);
        $banner = new Banner();
        if ($request->file('image')) {
            $file = $request->file('image')->store('banner', 'public');
            $banner->image = $file;
        }

        $banner->save();
        toast('Data Berhasil Disimpan','success');
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'mimes:JPG,jpeg,png,jpg,SVG,svg|max:3072',
        ]);
        $banner = Banner::find($request->id);

        if ($request->file('image')) {
            if ($banner->image && file_exists(storage_path('app/public/' . $banner->image))) {
                \Storage::delete('public/' . $banner->image);
            }
            $file = $request->file('image')->store('banner', 'public');
            $banner->image = $file;
        }

        $banner->save();
        toast('Data Berhasil Diubah','success');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $banner = Banner::find($request->id);
        if ($banner->image && file_exists(storage_path('app/public/' . $banner->image))) {
            \Storage::delete('public/' . $banner->image);
        }
        $banner->delete();
        toast('Data Berhasil Dihapus','success');
        return redirect()->back();
    }
}
