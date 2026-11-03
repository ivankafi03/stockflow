<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StockFlow | Enterprise Inventory & Asset Tracking</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen flex flex-col justify-between selection:bg-slate-700 selection:text-white font-sans">
    <!-- Corporate Header -->
    <header class="max-w-7xl mx-auto w-full px-6 py-5 flex items-center justify-between border-b border-slate-800/80">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <span class="font-bold text-lg tracking-tight uppercase text-white">STOCK<span class="text-blue-500">FLOW</span></span>
                <span class="hidden sm:inline-block text-[11px] text-slate-500 font-medium ml-2 pl-2 border-l border-slate-800">Enterprise Inventory Solution</span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded text-xs uppercase tracking-wider transition">
                    Dashboard &rarr;
                </a>
            @else
                <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-300 hover:text-white uppercase tracking-wider transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white font-semibold rounded text-xs uppercase tracking-wider transition border border-slate-700">
                    Registrasi
                </a>
            @endauth
        </div>
    </header>

    <!-- Hero Section -->
    <main class="max-w-7xl mx-auto px-6 py-16 flex-1 flex flex-col justify-center items-center text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-slate-900 border border-slate-800 text-slate-400 text-xs font-medium mb-8">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
            Integrated Supply Chain & Warehouse Management System
        </div>

        <h1 class="text-3xl sm:text-5xl font-bold tracking-tight max-w-4xl text-white leading-tight">
            Sistem Informasi Manajemen Persediaan & Pengawasan Aset Logistik
        </h1>

        <p class="mt-5 text-base text-slate-400 max-w-2xl leading-relaxed font-normal">
            Solusi terpadu untuk monitoring saldo persediaan fisik, pencatatan mutasi barang masuk dan keluar, pengawasan ambang batas persediaan kritis, serta rekapitulasi pelaporan terstandarisasi.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded text-xs uppercase tracking-wider transition">
                    Akses Dashboard Sistem
                </a>
            @else
                <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded text-xs uppercase tracking-wider transition">
                    Masuk ke Sistem Demo
                </a>
                <a href="{{ route('register') }}" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 border border-slate-800 text-slate-200 font-semibold rounded text-xs uppercase tracking-wider transition">
                    Pendaftaran Pengguna Baru
                </a>
            @endauth
        </div>

        <!-- 4 Key Functional Highlights -->
        <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-left max-w-6xl w-full">
            <div class="p-5 rounded bg-slate-900/80 border border-slate-800">
                <div class="w-8 h-8 rounded bg-slate-800 text-slate-300 flex items-center justify-center mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <h3 class="font-bold text-white text-sm">Master Data & SKU</h3>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed">Pengelolaan kode unik SKU, klasifikasi kategori berjenjang, dan dokumentasi visual.</p>
            </div>

            <div class="p-5 rounded bg-slate-900/80 border border-slate-800">
                <div class="w-8 h-8 rounded bg-slate-800 text-slate-300 flex items-center justify-center mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
                <h3 class="font-bold text-white text-sm">Audit Trail Mutasi</h3>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed">Pencatatan transaksi Inbound dan Outbound terintegrasi dengan nomor referensi dan user audit.</p>
            </div>

            <div class="p-5 rounded bg-slate-900/80 border border-slate-800">
                <div class="w-8 h-8 rounded bg-slate-800 text-slate-300 flex items-center justify-center mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="font-bold text-white text-sm">Ambang Batas Minimum</h3>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed">Deteksi dini persediaan yang mendekati batas kritis untuk menjaga ketersediaan pasokan.</p>
            </div>

            <div class="p-5 rounded bg-slate-900/80 border border-slate-800">
                <div class="w-8 h-8 rounded bg-slate-800 text-slate-300 flex items-center justify-center mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="font-bold text-white text-sm">Valuasi & Ekspor CSV</h3>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed">Kalkulasi total valuasi perolehan aset dan fasilitas unduh berkas data format Excel/CSV.</p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="max-w-7xl mx-auto w-full px-6 py-5 border-t border-slate-900 text-center text-xs text-slate-500">
        StockFlow Enterprise Edition &copy; 2026. Seluruh hak cipta dilindungi.
    </footer>
</body>
</html>
