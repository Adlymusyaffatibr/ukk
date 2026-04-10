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

        $produkRestock = Product::where('stock', '<', 5)->get();

        return view('admin.dashboard', compact('totalPemasukan', 'produkRestock'));
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
