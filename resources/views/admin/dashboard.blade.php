@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p class="text-gray-600">
            Ini adalah halaman dashboard utama. Silakan gunakan menu di sebelah kiri untuk menavigasi aplikasi.
        </p>

    </div>

    <div class="bg-green-100 p-4 rounded mb-4">
        <h2 class="text-lg font-semibold">Total Pemasukan</h2>
        <p class="text-2xl font-bold">
            Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
        </p>
    </div>

    <div class="bg-red-100 p-4 rounded">
        <h2 class="text-lg font-semibold mb-2">Produk Perlu Restock</h2>

        @forelse($produkRestock as $p)
            <div class="flex justify-between border-b py-1">
                <span>{{ $p->name }}</span>
                <span class="text-red-600">Stok: {{ $p->stock }}</span>
            </div>
        @empty
            <p class="text-gray-500">Semua stok aman 👍</p>
        @endforelse
    </div>
@endsection
