@extends('layouts.petugas')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Pembayaran</h1>

    <form method="POST" action="/petugas/pembelian">
        @csrf

        @if (session('error'))
            <script>
                alert("{{ session('error') }}");
            </script>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-2 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-xl shadow grid grid-cols-2 gap-6">

            <div>
                <h2 class="font-bold mb-4">Produk yang dipilih</h2>

                @foreach ($products as $p)
                    <div class="flex justify-between mb-2">
                        <div>
                            <p>{{ $p['name'] }}</p>
                            <small>
                                Rp {{ number_format($p['price'], 0, ',', '.') }}
                                x {{ $p['qty'] }}
                            </small>
                        </div>
                        <div>
                            Rp {{ number_format($p['subtotal'], 0, ',', '.') }}
                        </div>
                    </div>

                    <input type="hidden" name="items[{{ $p['id'] }}][id]" value="{{ $p['id'] }}">
                    <input type="hidden" name="items[{{ $p['id'] }}][qty]" value="{{ $p['qty'] }}">
                @endforeach

                <hr class="my-4">

                <h2 class="text-xl font-bold">
                    Total Rp {{ number_format($total, 0, ',', '.') }}
                </h2>
            </div>

            <div>

                <label class="block mb-2">Status Member</label>
                <select id="member" name="is_member" class="border p-2 w-full mb-3">
                    <option value="0">Bukan Member</option>
                    <option value="1">Member</option>
                </select>

                <div id="nameBox" class="hidden">
                    <input name="customer_name" placeholder="Nama Pelanggan" class="border p-2 w-full mb-3">
                </div>

                <div id="phoneBox" class="hidden">
                    <input name="phone" placeholder="No HP" class="border p-2 w-full mb-3">
                </div>

                <div id="usePointBox" class="hidden">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="use_points" value="1">
                        Gunakan poin
                    </label>
                    <p id="pointInfo" class="text-green-600 text-sm mt-2 hidden"></p>
                </div>

                <label>Total Bayar</label>
                <input id="paid" name="paid" type="number" required min="1" class="border p-2 w-full mb-2">

                <p id="kurang" class="text-red-500 text-sm hidden">
                    Uang kurang!
                </p>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded mt-4 w-full">
                    Pesan
                </button>

            </div>

        </div>
    </form>

    <script>
        let total = {{ $total }};

        document.getElementById('member').addEventListener('change', function() {
            let isMember = this.value == 1;

            document.getElementById('nameBox').classList.toggle('hidden', !isMember);
            document.getElementById('phoneBox').classList.toggle('hidden', !isMember);

            if (!isMember) {
                document.getElementById('usePointBox').classList.add('hidden');
            }
        });

        let phoneInput = document.querySelector('input[name="phone"]');

        phoneInput.addEventListener('keyup', function() {
            if (this.value.length > 5) {

                fetch('/petugas/cek-member?phone=' + this.value)
                    .then(res => res.json())
                    .then(data => {

                        if (data.is_member_old) {
                            document.getElementById('usePointBox').classList.remove('hidden');

                            let pointInfo = document.getElementById('pointInfo');
                            pointInfo.classList.remove('hidden');
                            pointInfo.innerHTML = `
                            Poin dimiliki: ${data.points} <br>
                            Poin dari transaksi ini: ${Math.floor(total * 0.01)}
                        `;

                        } else {
                            document.getElementById('usePointBox').classList.add('hidden');

                            document.querySelector('input[name="use_points"]').checked = false;

                            document.getElementById('pointInfo').classList.add('hidden');
                        }

                    });

            } else {
                document.getElementById('usePointBox').classList.add('hidden');
            }
        });
    </script>
@endsection
