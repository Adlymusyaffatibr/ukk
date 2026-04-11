<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KasirApp</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center px-4">

    <div class="grid md:grid-cols-2 bg-white shadow-lg rounded-xl overflow-hidden max-w-5xl w-full">

        <!-- LEFT (Info) -->
        <div class="bg-blue-500 text-white p-10 hidden md:flex flex-col justify-center">
            <h2 class="text-3xl font-bold mb-4">KasirApp</h2>
            <p class="mb-6">
                Kelola bisnis Anda dengan lebih mudah dan efisien menggunakan sistem kasir modern.
            </p>

            <ul class="space-y-2 text-blue-100">
                <li>Manajemen Produk</li>
                <li>Transaksi Cepat</li>
                <li>Laporan Otomatis</li>
            </ul>
        </div>

        <!-- RIGHT (Form) -->
        <div class="p-10">

            <h2 class="text-2xl font-bold mb-6 text-gray-800">Login</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block mb-1 text-sm">Email</label>
                    <input type="email" name="email"
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                        required>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block mb-1 text-sm">Password</label>
                    <input type="password" name="password"
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                        required>
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg font-semibold transition">
                    Login
                </button>

                <!-- Register -->
                <p class="text-sm text-center mt-4">
                    Belum punya akun?
                    <a href="/register" class="text-blue-500 hover:underline">
                        Daftar
                    </a>
                </p>

            </form>
        </div>

    </div>

</div>

</body>
</html>