<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
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

        return view('admin.dashboard', compact(
            'totalPemasukan',
            'pemasukanHariIni',
            'pemasukanBulanan',
            'pemasukanTahunan',
            'totalMember',
            'totalNonMember',
            'produkRestock'
        ));
    }

    public function produk(){
        return view('admin.produk');
    }

    public function pembelian(){
        return view('admin.pembelian');
    }

    public function user(){
        return view('admin.user');
    }
}
