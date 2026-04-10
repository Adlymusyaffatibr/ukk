<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PetugasController extends Controller
{
    public function dashboard()
    {
        return view('petugas.dashboard');
    }

    public function produk(Request $request)
    {
        $search = $request->search;

        $products = Product::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->latest()
            ->paginate(10);

        return view('petugas.produk', compact('products', 'search'));
    }
}
