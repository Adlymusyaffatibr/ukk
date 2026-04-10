<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.pembelian', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('details')->findOrFail($id);
        return response()->json($order);
    }

    public function export()
    {
        return Excel::download(new OrderExport, 'pembelian.xlsx');
    }
}
