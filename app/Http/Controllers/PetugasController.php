<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function dashboard()
    {
        return view('petugas.dashboard');
    }

    public function produk(Request $request)
    {
        $search = $request->search;

        $products = Produk::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        })
            ->latest()
            ->paginate();

        return view('petugas.produk', compact('products', 'search'));
    }
}
