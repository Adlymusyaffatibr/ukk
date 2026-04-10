@extends('layouts.petugas')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Pembelian</h1>

    <div class="bg-white p-6 rounded-xl shadow">

        <!-- HEADER -->
        <div class="flex justify-between mb-4">

            <div class="flex gap-2">
                <a href="/petugas/pembelian-export" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Export Pembelian (.xlsx)
                </a>

                <a href="/petugas/pembelian/create" class="bg-blue-700 text-white px-4 py-2 rounded">
                    Tambah Pembelian
                </a>
            </div>

            <form>
                <input name="search" placeholder="Cari..." class="border p-2 rounded" value="{{ request('search') }}">
            </form>
        </div>

        <table class="w-full text-left">
            <thead>
                <tr class="border-b text-gray-500">
                    <th>#</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Dibuat Oleh</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($orders as $i => $o)
                    <tr class="border-b">
                        <td>{{ $orders->firstItem() + $i }}</td>

                        <td>{{ $o->customer_name ?? 'NON-MEMBER' }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($o->created_at)->translatedFormat('d F Y') }}
                        </td>

                        <td>Rp {{ number_format($o->total_price, 0, ',', '.') }}</td>

                        <td>{{ auth()->user()->name }}</td>

                        <td>
                            <button onclick="lihat({{ $o->id }})" class="bg-yellow-400 px-3 py-1 rounded text-white">
                                Lihat
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>

    </div>

    <!-- MODAL DETAIL -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded w-96 relative">

            <button onclick="closeModal()" class="absolute right-3 top-2 text-xl">✕</button>

            <h2 class="font-bold mb-4">Detail</h2>

            <div id="detailContent"></div>

        </div>
    </div>

    <script>
        function lihat(id) {
            fetch('/petugas/pembelian/' + id)
                .then(res => res.json())
                .then(data => {
                    let html = `
        <p><b>Nama:</b> ${data.customer_name ?? 'NON MEMBER'}</p>
        <p><b>Total:</b> Rp ${format(data.total_price)}</p>
        <hr class="my-2">`;

                    data.details.forEach(d => {
                        html += `
            <div class="flex justify-between">
                <span>${d.product_name} (${d.qty})</span>
                <span>Rp ${format(d.price)}</span>
            </div>`;
                    });

                    document.getElementById('detailContent').innerHTML = html;
                    document.getElementById('modal').classList.remove('hidden');
                });
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        function format(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }
    </script>
@endsection
