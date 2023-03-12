<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        return view('pages.admin.product.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'mimes:JPG,jpeg,png,jpg,SVG,svg|max:3072',
        ]);
        $product = new Product();
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        if ($request->file('image')) {
            $file = $request->file('image')->store('produk', 'public');
            $product->image = $file;
        }

        $product->save();
        toast('Data Berhasil Disimpan','success');
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'mimes:JPG,jpeg,png,jpg,SVG,svg|max:3072',
        ]);
        $product = Product::find($request->id);

        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        if ($request->file('image')) {
            if ($product->image && file_exists(storage_path('app/public/' . $product->image))) {
                \Storage::delete('public/' . $product->image);
            }
            $file = $request->file('image')->store('produk', 'public');
            $product->image = $file;
        }

        $product->save();
        toast('Data Berhasil Diubah','success');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        if ($product->image && file_exists(storage_path('app/public/' . $product->image))) {
            \Storage::delete('public/' . $product->image);
        }
        $product->delete();
        toast('Data Berhasil Dihapus','success');
        return redirect()->back();
    }
}
