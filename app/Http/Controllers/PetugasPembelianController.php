<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasPembelianController extends Controller
{
    public function index(Request $req)
    {
        $q = $req->search;

        $orders = Order::when($q, function ($query) use ($q) {
            $query->whereRaw('LOWER(customer_name) LIKE ?', ['%' . strtolower($q) . '%']);
        })->latest()->paginate(10);

        return view('petugas.pembelian', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('petugas.transaksi', compact('products'));
    }

    public function checkout(Request $r)
    {
        if (!$r->items) {
            return redirect()->route('petugas.create')->with('error', 'Item kosong');
        }

        $items = collect($r->items)
            ->map(fn($i) => ['id' => $i['id'], 'qty' => (int)$i['qty']])
            ->filter(fn($i) => $i['qty'] > 0);

        if ($items->isEmpty()) {
            return redirect('/petugas/pembelian/create')->with('error', 'Pilih produk dulu');
        }

        $products = [];
        $total = 0;

        foreach ($items as $item) {
            $p = Product::find($item['id']);
            if (!$p) continue;

            $sub = $p->price * $item['qty'];
            $total += $sub;

            $products[] = [
                'id' => $p->id,
                'name' => $p->name,
                'price' => $p->price,
                'qty' => $item['qty'],
                'subtotal' => $sub
            ];
        }

        return view('petugas.checkout', compact('products', 'total'));
    }

    public function store(Request $r)
    {
        DB::beginTransaction();

        try {

            if (!$r->items) {
                return back()->with('error', 'Item kosong');
            }

            $total = 0;

            foreach ($r->items as $item) {
                $qty = (int)$item['qty'];
                if ($qty <= 0) continue;

                $p = Product::find($item['id']);
                if (!$p) throw new \Exception('Produk tidak ditemukan');

                if ($qty > $p->stock) {
                    throw new \Exception('Stok tidak cukup: ' . $p->name);
                }

                $total += $p->price * $qty;
            }

            if ($total <= 0) {
                throw new \Exception('Total tidak valid');
            }

            $pointsEarned = 0;
            $pointsUsed = 0;

            if ($r->is_member == 1) {

                if (!$r->phone) {
                    throw new \Exception('No HP wajib diisi');
                }

                $isFirst = Order::where('phone', $r->phone)->count() == 0;

                $totalPoints = Order::where('phone', $r->phone)->sum('points_earned')
                    - Order::where('phone', $r->phone)->sum('points_used');

                if (!$isFirst && $r->use_points == 1) {
                    $pointsUsed = min($totalPoints, floor($total * 0.01));
                    $total -= $pointsUsed;
                }

                $pointsEarned = floor($total * 0.01);
            }

            if ((int)$r->paid < $total) {
                throw new \Exception('Uang kurang');
            }

            $order = Order::create([
                'customer_name' => $r->is_member ? ($r->customer_name ?? 'Member') : 'NON-MEMBER',
                'phone' => $r->is_member ? $r->phone : null,
                'is_member' => $r->is_member ?? 0,
                'total_price' => $total,
                'paid' => $r->paid,
                'change' => $r->paid - $total,
                'points_used' => $pointsUsed,
                'points_earned' => $pointsEarned,
                'user_id' => auth()->id()
            ]);

            foreach ($r->items as $item) {
                $qty = (int)$item['qty'];
                if ($qty <= 0) continue;

                $p = Product::find($item['id']);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $p->id,
                    'product_name' => $p->name,
                    'price' => $p->price,
                    'qty' => $qty,
                ]);

                $p->decrement('stock', $qty);
            }

            DB::commit();

            return redirect('/petugas/struk/' . $order->id);
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        return response()->json(
            Order::with('details')->findOrFail($id)
        );
    }

    public function struk($id)
    {
        $order = Order::with('details')->findOrFail($id);
        return view('petugas.struk', compact('order'));
    }
}
