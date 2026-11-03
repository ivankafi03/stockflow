<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StockFlow — Smart Inventory & Asset Tracker</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-900 text-slate-100 min-h-screen flex flex-col justify-between selection:bg-indigo-500 selection:text-white">
    <!-- Header -->
    <header class="max-w-7xl mx-auto w-full px-6 py-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-3xl">📦</span>
            <span class="font-extrabold text-2xl tracking-tight text-white">Stock<span class="text-indigo-400">Flow</span></span>
        </div>
        <div class="flex items-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg text-sm transition">
                    Buka Dashboard &rarr;
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-white transition">
                    Log in
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg text-sm transition">
                    Register
                </a>
            @endauth
        </div>
    </header>

    <!-- Hero Section -->
    <main class="max-w-7xl mx-auto px-6 py-12 flex-1 flex flex-col justify-center items-center text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-xs font-semibold mb-6">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Sistem Manajemen Inventaris & Mutasi Stok Real-Time
        </div>

        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight max-w-4xl text-white leading-tight">
            Kendali Stok & Mutasi Aset Kantor Jadi <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">Lebih Akurat & Cepat</span>
        </h1>

        <p class="mt-6 text-lg text-slate-400 max-w-2xl leading-relaxed">
            Aplikasi pencatatan stok barang, audit trail barang masuk/keluar, sistem peringatan stok menipis otomatis, serta ekspor laporan ke CSV.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row items-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-base shadow-lg shadow-indigo-600/30 transition">
                    Masuk ke Dashboard &rarr;
                </a>
            @else
                <a href="{{ route('login') }}" class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-base shadow-lg shadow-indigo-600/30 transition">
                    Coba Demo Sekarang
                </a>
                <a href="{{ route('register') }}" class="px-6 py-3.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white font-semibold rounded-xl text-base transition">
                    Buat Akun Baru
                </a>
            @endauth
        </div>

        <!-- 4 Key Highlights -->
        <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 text-left max-w-6xl w-full">
            <div class="p-5 rounded-xl bg-slate-800/60 border border-slate-700/60 backdrop-blur">
                <div class="text-2xl mb-2">🏷️</div>
                <h3 class="font-bold text-white text-base">Master Barang & SKU</h3>
                <p class="text-xs text-slate-400 mt-1">Kode SKU unik otomatis, kategori multi-level, dan foto barang.</p>
            </div>

            <div class="p-5 rounded-xl bg-slate-800/60 border border-slate-700/60 backdrop-blur">
                <div class="text-2xl mb-2">🔄</div>
                <h3 class="font-bold text-white text-base">Audit Mutasi Stok</h3>
                <p class="text-xs text-slate-400 mt-1">Catat transaksi In & Out dengan no. referensi dan audit log operator.</p>
            </div>

            <div class="p-5 rounded-xl bg-slate-800/60 border border-slate-700/60 backdrop-blur">
                <div class="text-2xl mb-2">⚠️</div>
                <h3 class="font-bold text-white text-base">Low Stock Alert</h3>
                <p class="text-xs text-slate-400 mt-1">Notifikasi visual otomatis jika stok barang mendekati batas minimum.</p>
            </div>

            <div class="p-5 rounded-xl bg-slate-800/60 border border-slate-700/60 backdrop-blur">
                <div class="text-2xl mb-2">📊</div>
                <h3 class="font-bold text-white text-base">Export CSV & Valuasi</h3>
                <p class="text-xs text-slate-400 mt-1">Download rekap inventaris format Excel/CSV & hitung total valuasi aset.</p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="max-w-7xl mx-auto w-full px-6 py-6 border-t border-slate-800 text-center text-xs text-slate-500">
        StockFlow — Portfolio Project dibangun dengan Laravel 10, Tailwind CSS, & SQLite.
    </footer>
</body>
</html>
