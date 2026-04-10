<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
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
