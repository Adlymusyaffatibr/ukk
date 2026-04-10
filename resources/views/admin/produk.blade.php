@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">Produk</h1>

<div class="bg-white p-6 rounded-xl shadow">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold">Daftar Produk</h2>

        <button onclick="openModal('addModal')"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            Tambah Produk
        </button>
    </div>

    <table class="w-full text-left">
        <thead>
            <tr class="text-gray-500 border-b">
                <th>#</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $i => $p)
            <tr class="border-b">
                <td>{{ $i+1 }}</td>

                <td class="flex items-center gap-3">
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}" class="w-12 h-12 rounded">
                    @else
                        <div class="w-12 h-12 bg-gray-200 rounded"></div>
                    @endif
                    {{ $p->name }}
                </td>

                <td>Rp {{ number_format($p->price,0,',','.') }}</td>
                <td>{{ $p->stock }}</td>

                <td class="text-center space-x-2">

                    <button onclick="openEdit({{ $p }})"
                        class="bg-yellow-400 px-2 py-1 rounded text-white">
                        Edit
                    </button>

                    <button onclick="openStock({{ $p }})"
                        class="bg-blue-500 px-2 py-1 rounded text-white">
                        Stok
                    </button>

                    <button onclick="openDelete({{ $p->id }})"
                        class="bg-red-500 px-2 py-1 rounded text-white">
                        Hapus
                    </button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@if(session('success'))
<div id="toast" class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded shadow
translate-x-full opacity-0 transition duration-500">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div id="toast" class="fixed top-5 right-5 bg-red-500 text-white px-6 py-3 rounded shadow
translate-x-full opacity-0 transition duration-500">
    {{ session('error') }}
</div>
@endif


<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
<div class="bg-white p-6 rounded w-96 relative">

<button onclick="closeModal('addModal')" class="absolute right-3 top-2 text-xl">✕</button>

<h2 class="mb-4 font-bold">Tambah Produk</h2>

<form method="POST" action="/admin/produk" enctype="multipart/form-data">
@csrf

<input name="name" placeholder="Nama" class="border p-2 w-full mb-1">
@error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

<input id="price" name="price" placeholder="Harga" class="border p-2 w-full mb-1">
@error('price') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

<input name="stock" placeholder="Stok" class="border p-2 w-full mb-1">
@error('stock') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

<input type="file" name="image">
@error('image') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

<button class="bg-blue-500 text-white w-full mt-3 p-2 rounded">Simpan</button>
</form>

</div>
</div>


<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
<div class="bg-white p-6 rounded w-96 relative">

<button onclick="closeModal('editModal')" class="absolute right-3 top-2 text-xl">✕</button>

<h2 class="mb-4 font-bold">Edit Produk</h2>

<form method="POST" id="editForm" enctype="multipart/form-data">
@csrf @method('PUT')

<input id="edit_name" name="name" class="border p-2 w-full mb-2">
<input id="edit_price" name="price" class="border p-2 w-full mb-2">

<input type="file" name="image">

<button class="bg-yellow-500 text-white w-full mt-3 p-2 rounded">Update</button>
</form>

</div>
</div>


<div id="stockModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
<div class="bg-white p-6 rounded w-96 relative">

<button onclick="closeModal('stockModal')" class="absolute right-3 top-2 text-xl">✕</button>

<h2 class="mb-4 font-bold">Update Stok</h2>

<form method="POST" id="stockForm">
@csrf @method('PUT')

<input id="stock_value" name="stock" placeholder="Masukkan stok"
    class="border p-2 w-full mb-1">

<p id="stockError" class="text-red-500 text-sm hidden">
    Stok wajib diisi!
</p>

<button type="button" onclick="submitStock()"
    class="bg-blue-500 text-white w-full mt-3 p-2 rounded">
    Update
</button>

</form>

</div>
</div>


<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
<div class="bg-white p-8 rounded-lg text-center w-96">

<div class="text-5xl text-orange-400 mb-4">!</div>

<h2 class="text-xl font-bold mb-2">Yakin ingin hapus?</h2>
<p class="text-gray-500 mb-6">Data tidak bisa dikembalikan!</p>

<div class="flex justify-center gap-4">
    <button onclick="submitDelete()"
        class="bg-purple-600 text-white px-4 py-2 rounded">
        Ya, hapus!
    </button>

    <button onclick="closeModal('deleteModal')"
        class="bg-gray-400 text-white px-4 py-2 rounded">
        Batal
    </button>
</div>

</div>
</div>


<form id="deleteForm" method="POST">
@csrf @method('DELETE')
</form>

<script>

function openModal(id){ document.getElementById(id).classList.remove('hidden'); }
function closeModal(id){ document.getElementById(id).classList.add('hidden'); }

// EDIT
function openEdit(p){
    openModal('editModal');
    edit_name.value = p.name;
    edit_price.value = p.price;
    editForm.action = '/admin/produk/'+p.id;
}

// STOCK
function openStock(p){
    openModal('stockModal');
    stock_value.value = p.stock;
    stockForm.action = '/admin/produk/stock/'+p.id;
}

// VALIDASI STOCK
function submitStock(){
    let val = stock_value.value;

    if(val === '' || val === null){
        document.getElementById('stockError').classList.remove('hidden');
        stock_value.value = 0;
        return;
    }

    stockForm.submit();
}

// DELETE
let deleteId = null;

function openDelete(id){
    deleteId = id;
    openModal('deleteModal');
}

function submitDelete(){
    deleteForm.action = '/admin/produk/'+deleteId;
    deleteForm.submit();
}


// FORMAT HARGA
price.addEventListener('keyup', function(){
    this.value=this.value.replace(/[^0-9]/g,'');
});

@if($errors->any())
openModal('addModal');
@endif


window.addEventListener('DOMContentLoaded', () => {
    let toast = document.getElementById('toast');
    if(toast){
        setTimeout(() => {
            toast.classList.remove('translate-x-full','opacity-0');
        }, 100);

        setTimeout(() => {
            toast.classList.add('translate-x-full','opacity-0');
        }, 3000);
    }
});


window.onclick = function(e){
    ['addModal','editModal','stockModal','deleteModal'].forEach(id=>{
        let m=document.getElementById(id);
        if(e.target===m) closeModal(id);
    });
}

</script>

@endsection