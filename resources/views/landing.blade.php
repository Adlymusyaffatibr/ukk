<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasirApp</title>
</head>

<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow-md">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">

            <div class="flex items-center gap-3">
                <img src="/warung.png" alt="logo" class="w-10 h-10">
                <h1 class="text-2xl font-bold text-blue-600">KasirApp</h1>
            </div>

            <a href="/login"
                class="px-5 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                Login
            </a>
        </div>
    </nav>

    <section class="bg-blue-500 text-white">
        <div class="max-w-4xl mx-auto text-center px-6 py-24">

            <img src="/warung.png" class="w-20 mx-auto mb-6">

            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                Aplikasi Kasir Modern
            </h2>

            <p class="text-blue-100 mb-4">
                {{ config('app.store_address') }}
            </p>

            <p class="text-blue-100 mb-8 leading-relaxed">
                KasirApp adalah aplikasi kasir yang dibuat untuk membantu UMKM
                dalam mengelola transaksi, stok barang, dan laporan keuangan
                dalam satu platform yang praktis dan efisien.
            </p>

            <a href="/login"
                class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Mulai Sekarang
            </a>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h3 class="text-2xl font-bold mb-12">Fitur Unggulan</h3>

            <div class="grid md:grid-cols-3 gap-8">

                <div class="bg-white p-8 shadow-md rounded-xl hover:shadow-lg transition">
                    <h4 class="font-semibold text-lg mb-3">Manajemen Produk</h4>
                    <p class="text-gray-600 leading-relaxed">
                        Tambah, edit, dan kelola stok barang dengan mudah dan terstruktur.
                    </p>
                </div>

                <div class="bg-white p-8 shadow-md rounded-xl hover:shadow-lg transition">
                    <h4 class="font-semibold text-lg mb-3">Transaksi Cepat</h4>
                    <p class="text-gray-600 leading-relaxed">
                        Proses pembayaran dengan cepat, akurat, dan efisien.
                    </p>
                </div>

                <div class="bg-white p-8 shadow-md rounded-xl hover:shadow-lg transition">
                    <h4 class="font-semibold text-lg mb-3">Laporan Akurat</h4>
                    <p class="text-gray-600 leading-relaxed">
                        Lihat laporan penjualan harian dan bulanan dengan grafik
                        yang mudah dipahami dan bisa diakses kapan saja.
                    </p>
                </div>

            </div>
        </div>
    </section>

</body>

</html>
