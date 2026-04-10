@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p class="text-gray-600">
            Ini adalah halaman dashboard utama. Silakan gunakan menu di sebelah kiri untuk menavigasi aplikasi.
        </p>

        </div>
@endsection