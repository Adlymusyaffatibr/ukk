@extends('layouts.petugas')

@section('content')

<h1 class="text-3xl font-bold mb-6">Produk</h1>

<div class="bg-white p-6 rounded-xl shadow">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold">Daftar Produk</h2>

        <form method="GET">
            <input type="text" name="search" value="{{ $search }}"
                placeholder="Cari produk..."
                class="border px-3 py-2 rounded-lg">
        </form>
    </div>

    <table class="w-full text-left">
        <thead>
            <tr class="text-gray-500 border-b">
                <th>#</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $i => $p)
            <tr class="border-b hover:bg-gray-50">
                <td>{{ $products->firstItem() + $i }}</td>

                <td class="flex items-center gap-3">
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}"
                             class="w-12 h-12 object-cover rounded">
                    @else
                        <div class="w-12 h-12 bg-gray-200 rounded"></div>
                    @endif

                    {{ $p->name }}
                </td>

                <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                <td>{{ $p->stock }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4 text-gray-500">
                    Data tidak ditemukan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($products->total() > 10)
    <div class="mt-6">
        {{ $products->links() }}
    </div>
    @endif

</div>

@endsection