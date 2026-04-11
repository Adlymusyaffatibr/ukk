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

        $pemasukanHariIni = Order::whereDate('created_at', now())
            ->sum('total_price');

        $pemasukanBulanan = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $pemasukanTahunan = Order::whereYear('created_at', now()->year)
            ->sum('total_price');

        $totalMember = Order::where('is_member', true)->count();

        $totalNonMember = Order::where('is_member', false)->count();

        $produkRestock = Product::where('stock', '<', 5)->get();

        return view('petugas.dashboard', compact(
            'totalPemasukan',
            'pemasukanHariIni',
            'pemasukanBulanan',
            'pemasukanTahunan',
            'totalMember',
            'totalNonMember',
            'produkRestock'
        ));
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
