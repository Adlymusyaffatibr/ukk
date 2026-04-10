@extends('layouts.petugas')

@section('content')

<h1 class="text-3xl font-bold mb-6">Transaksi Pembelian</h1>

<form method="POST" action="/petugas/checkout">
@csrf

<div class="grid grid-cols-2 md:grid-cols-3 gap-6">

@foreach($products as $p)
<div class="bg-white p-4 rounded-xl shadow text-center">

    <img src="{{ asset('storage/'.$p->image) }}"
        class="w-24 h-24 object-cover mx-auto mb-2">

    <h2 class="font-semibold">{{ $p->name }}</h2>

    <p class="text-gray-500 text-sm">Stok {{ $p->stock }}</p>
    <p class="font-bold mb-2">Rp {{ number_format($p->price,0,',','.') }}</p>

    <!-- QTY CONTROL -->
    <div class="flex justify-center items-center gap-4 mb-2">
        <button type="button"
            onclick="minus({{ $p->id }})"
            class="px-3 py-1 bg-gray-200 rounded">-</button>

        <span id="qty-{{ $p->id }}">0</span>

        <button type="button"
            onclick="plus({{ $p->id }}, {{ $p->stock }})"
            class="px-3 py-1 bg-gray-200 rounded">+</button>
    </div>

    <p class="text-sm text-gray-600">
        Sub Total Rp.
        <span id="sub-{{ $p->id }}">0</span>
    </p>

    <input type="hidden" name="items[{{ $p->id }}][id]" value="{{ $p->id }}">
    <input type="hidden" id="input-{{ $p->id }}" name="items[{{ $p->id }}][qty]" value="0">

</div>
@endforeach

</div>

<div class="mt-8 text-right">
    <h2 class="text-xl font-bold">
        Total: Rp <span id="grandTotal">0</span>
    </h2>
</div>

<div class="mt-6 text-center">
    <button class="bg-blue-600 text-white px-6 py-2 rounded">
        Selanjutnya
    </button>
</div>

</form>

<script>

let prices = {
    @foreach($products as $p)
        {{ $p->id }}: {{ $p->price }},
    @endforeach
};

let qty = {};
let total = 0;

@foreach($products as $p)
qty[{{ $p->id }}] = 0;
@endforeach

function plus(id, stock){
    if(qty[id] >= stock) return;

    qty[id]++;
    update(id);
}

function minus(id){
    if(qty[id] <= 0) return;

    qty[id]--;
    update(id);
}

function update(id){
    document.getElementById('qty-'+id).innerText = qty[id];

    let sub = qty[id] * prices[id];
    document.getElementById('sub-'+id).innerText = format(sub);

    document.getElementById('input-'+id).value = parseInt(qty[id]);

    hitungTotal();
}

function hitungTotal(){
    total = 0;

    for(let id in qty){
        total += qty[id] * prices[id];
    }

    document.getElementById('grandTotal').innerText = format(total);
}

function format(num){
    return new Intl.NumberFormat('id-ID').format(num);
}

</script>

@endsection