@extends('layouts.petugas')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Dashboard Petugas</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-white p-5 rounded-2xl shadow border hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Total Pemasukan</p>
            <h2 class="text-2xl font-bold text-green-600 mt-2">
                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow border hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Hari Ini</p>
            <h2 class="text-2xl font-bold text-blue-600 mt-2">
                Rp {{ number_format($pemasukanHariIni, 0, ',', '.') }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow border hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Bulan Ini</p>
            <h2 class="text-2xl font-bold text-yellow-500 mt-2">
                Rp {{ number_format($pemasukanBulanan, 0, ',', '.') }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow border hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Tahun Ini</p>
            <h2 class="text-2xl font-bold text-purple-600 mt-2">
                Rp {{ number_format($pemasukanTahunan, 0, ',', '.') }}
            </h2>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

        <div class="bg-white p-5 rounded-2xl shadow border">
            <p class="text-gray-500 text-sm">Member</p>
            <h2 class="text-2xl font-bold text-green-600">
                {{ $totalMember }} Orang
            </h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow border">
            <p class="text-gray-500 text-sm">Non Member</p>
            <h2 class="text-2xl font-bold text-red-600">
                {{ $totalNonMember }} Orang
            </h2>
        </div>

    </div>

    <div class="bg-white p-6 rounded-2xl shadow border mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">
            Selamat Datang, {{ auth()->user()->name }}
        </h2>
        <p class="text-gray-600">
            Ini adalah halaman dashboard utama. Gunakan menu di sebelah kiri untuk navigasi aplikasi.
        </p>
    </div>

    <div class="bg-red-100 p-5 rounded-2xl">
        <h2 class="text-lg font-semibold mb-3">Produk Perlu Restock</h2>

        @forelse($produkRestock as $p)
            <div class="flex justify-between border-b py-2 text-sm">
                <span>{{ $p->name }}</span>
                <span class="text-red-600 font-semibold">
                    Stok: {{ $p->stock }}
                </span>
            </div>
        @empty
            <p class="text-gray-600">Semua stok aman </p>
        @endforelse
    </div>
@endsection
