<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $totalPemasukan = Order::sum('total_price');

        $produkRestock = Product::where('stock', '<', 5)->get();

        return view('petugas.dashboard', compact('totalPemasukan', 'produkRestock'));
    }

    public function produk(Request $request)
    {
        $search = $request->search;

        $products = Product::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        })
            ->latest()
            ->paginate(10);

        return view('petugas.produk', compact('products', 'search'));
    }
}
