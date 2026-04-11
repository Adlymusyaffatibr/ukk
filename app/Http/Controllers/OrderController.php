<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;
use Carbon\Carbon;

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

    public function export(Request $request)
{
    $from = $request->from;
    $to   = $request->to;

    if (!$from || !$to) {
        return back()->with('error', 'Pilih tanggal dari & sampai dulu!');
    }

    $start = Carbon::parse($from)->startOfDay();
    $end   = Carbon::parse($to)->endOfDay();

    $orders = Order::whereBetween('created_at', [$start, $end])
        ->orderBy('created_at', 'asc')
        ->get();

    return Excel::download(new OrderExport($orders), 'pembelian.xlsx');
}
}
