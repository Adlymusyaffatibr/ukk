<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - KasirApp</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <aside class="w-64 bg-blue-600 text-white p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-8">KasirApp</h2>

            <nav class="space-y-4">
                <a href="/admin/dashboard" class="block hover:bg-blue-700 p-2 rounded">Dashboard</a>
                <a href="/admin/produk" class="block hover:bg-blue-700 p-2 rounded">Produk</a>
                <a href="/admin/pembelian" class="block hover:bg-blue-700 p-2 rounded">Penjualan</a>
                <a href="/admin/user" class="block hover:bg-blue-700 p-2 rounded">User</a>
            </nav>
        </div>

        <form method="POST" action="/logout">
            @csrf
            <button class="block hover:bg-blue-700 p-2 rounded w-full text-left">
                Logout
            </button>
        </form>
    </aside>

    <main class="flex-1 p-8">
        @yield('content')
    </main>

</div>

</body>
</html>
