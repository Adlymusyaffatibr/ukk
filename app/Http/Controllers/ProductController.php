<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.produk', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        $image = null;
        if ($request->file('image')) {
            $image = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $image,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambah');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        if ($request->file('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->back()->with('error', 'Produk berhasil dihapus');
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|numeric|min:0'
        ]);

        Product::findOrFail($id)->update([
            'stock' => $request->stock
        ]);

        return redirect()->back()->with('success', 'Stok berhasil diupdate');
    }
}
