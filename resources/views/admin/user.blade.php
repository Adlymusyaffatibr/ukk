@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">User</h1>

<div class="bg-white p-6 rounded-xl shadow">

    <div class="flex justify-end mb-4">
        <button onclick="openModal('addModal')"
            class="bg-blue-600 text-white px-4 py-2 rounded">
            Tambah User
        </button>
    </div>

    <table class="w-full text-left">
        <thead>
            <tr class="border-b text-gray-500">
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $i => $u)
            <tr class="border-b">
                <td>{{ $i+1 }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role }}</td>

                <td class="space-x-2">

                    <button onclick="openEdit({{ $u }})"
                        class="bg-yellow-400 px-3 py-1 rounded text-white">
                        Edit
                    </button>

                    <button onclick="openDelete({{ $u->id }})"
                        class="bg-red-500 px-3 py-1 rounded text-white">
                        Hapus
                    </button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

{{-- TOAST --}}
@if(session('success'))
<div id="toast" class="fixed top-5 right-5 bg-green-500 text-white px-5 py-2 rounded shadow">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div id="toast" class="fixed top-5 right-5 bg-red-500 text-white px-5 py-2 rounded shadow">
    {{ session('error') }}
</div>
@endif


{{-- MODAL ADD --}}
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
<div class="bg-white p-6 rounded w-96 relative">

<button onclick="closeModal('addModal')" class="absolute right-3 top-2">✕</button>

<h2 class="mb-4 font-bold">Tambah User</h2>

<form method="POST" action="/admin/user">
@csrf

<input name="name" placeholder="Nama" class="border p-2 w-full mb-2">

<input name="email" placeholder="Email" class="border p-2 w-full mb-2">

<input type="password" name="password" placeholder="Password"
    class="border p-2 w-full mb-2">

<select name="role" class="border p-2 w-full mb-2">
    <option value="admin">Admin</option>
    <option value="petugas">Petugas</option>
</select>

<button class="bg-blue-500 text-white w-full p-2 rounded">Simpan</button>
</form>

</div>
</div>


{{-- MODAL EDIT --}}
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
<div class="bg-white p-6 rounded w-96 relative">

<button onclick="closeModal('editModal')" class="absolute right-3 top-2">✕</button>

<h2 class="mb-4 font-bold">Edit User</h2>

<form method="POST" id="editForm">
@csrf @method('PUT')

<input id="edit_name" name="name" class="border p-2 w-full mb-2">

<input id="edit_email" name="email" class="border p-2 w-full mb-2">

<input type="password" name="password"
    placeholder="Kosongkan jika tidak diubah"
    class="border p-2 w-full mb-2">

<select id="edit_role" name="role" class="border p-2 w-full mb-2">
    <option value="admin">Admin</option>
    <option value="petugas">Petugas</option>
</select>

<button class="bg-yellow-500 text-white w-full p-2 rounded">Update</button>
</form>

</div>
</div>


{{-- MODAL DELETE --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
<div class="bg-white p-6 rounded text-center w-80">

<h2 class="text-lg font-bold mb-2">Yakin hapus?</h2>
<p class="text-gray-500 mb-4">Data tidak bisa dikembalikan</p>

<div class="flex justify-center gap-3">
    <button onclick="submitDelete()"
        class="bg-red-500 text-white px-4 py-2 rounded">
        Hapus
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

function openEdit(u){
    openModal('editModal');
    edit_name.value = u.name;
    edit_email.value = u.email;
    edit_role.value = u.role;
    editForm.action = '/admin/user/'+u.id;
}

let deleteId;
function openDelete(id){
    deleteId = id;
    openModal('deleteModal');
}

function submitDelete(){
    deleteForm.action = '/admin/user/'+deleteId;
    deleteForm.submit();
}

/* TOAST AUTO HILANG */
setTimeout(()=>{
    let t=document.getElementById('toast');
    if(t) t.remove();
},3000);
</script>

@endsection