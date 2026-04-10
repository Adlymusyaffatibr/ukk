@extends('layouts.petugas')

@section('content')

<h1 class="text-3xl font-bold mb-6">Struk Pembayaran</h1>

<div class="bg-white p-6 rounded-xl shadow max-w-xl mx-auto">

    <h2 class="text-xl font-bold mb-4 text-center">KasirApp</h2>

    <p><b>Nama:</b> {{ $order->customer_name }}</p>
    <p><b>Tanggal:</b> {{ $order->created_at->format('d-m-Y H:i') }}</p>

    <hr class="my-3">

    @foreach($order->details as $d)
    <div class="flex justify-between mb-2">
        <div>
            {{ $d->product_name }} ({{ $d->qty }})
        </div>
        <div>
            Rp {{ number_format($d->price * $d->qty,0,',','.') }}
        </div>
    </div>
    @endforeach

    <hr class="my-3">

    <p class="flex justify-between">
        <span>Total</span>
        <span>Rp {{ number_format($order->total_price + $order->points_used,0,',','.') }}</span>
    </p>

    @if($order->points_used > 0)
    <p class="flex justify-between text-green-600">
        <span>Poin Digunakan</span>
        <span>- Rp {{ number_format($order->points_used,0,',','.') }}</span>
    </p>
    @endif

    <p class="flex justify-between font-bold text-lg mt-2">
        <span>Total Bayar</span>
        <span>Rp {{ number_format($order->total_price,0,',','.') }}</span>
    </p>

    <p class="flex justify-between mt-2">
        <span>Dibayar</span>
        <span>Rp {{ number_format($order->paid,0,',','.') }}</span>
    </p>

    <p class="flex justify-between">
        <span>Kembalian</span>
        <span>Rp {{ number_format($order->change,0,',','.') }}</span>
    </p>

    @if($order->is_member)
    <hr class="my-3">
    <p><b>Poin Didapat:</b> {{ $order->points_earned }}</p>
    @endif

    <div class="flex gap-3 mt-6">

        <a href="/petugas/pembelian"
            class="w-full text-center bg-gray-500 text-white py-2 rounded">
            Kembali
        </a>

        <button onclick="window.print()"
            class="w-full bg-blue-600 text-white py-2 rounded">
            Unduh / Print
        </button>

    </div>

</div>

@endsection