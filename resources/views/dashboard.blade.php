<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Dashboard Overview
                </h2>
                <p class="text-sm text-gray-500 mt-1">Ringkasan kondisi inventaris dan pergerakan stok real-time.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('items.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Barang
                </a>
                <a href="{{ route('movements.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    Transaksi Stok
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- 4 Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total Items -->
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Item Barang</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ number_format($totalItems) }}</p>
                    <p class="text-xs text-gray-400 mt-1">Terbagi di {{ $totalCategories }} kategori</p>
                </div>
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-xl">
                    📦
                </div>
            </div>

            <!-- Total Stock Quantity -->
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Unit Fisik</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ number_format($totalStockQty) }}</p>
                    <p class="text-xs text-gray-400 mt-1">Kuantitas di seluruh gudang</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                    📊
                </div>
            </div>

            <!-- Total Asset Value -->
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Nilai Aset</p>
                    <p class="text-2xl font-extrabold text-gray-900 mt-2">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">Berdasarkan harga modal beli</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
                    💰
                </div>
            </div>

            <!-- Low / Out of Stock Alert Card -->
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between {{ ($lowStockItems->count() + $outOfStockItems->count()) > 0 ? 'border-amber-300 ring-2 ring-amber-100' : '' }}">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Perlu Perhatian</p>
                    <p class="text-3xl font-extrabold {{ ($lowStockItems->count() + $outOfStockItems->count()) > 0 ? 'text-amber-600' : 'text-gray-900' }} mt-2">
                        {{ $lowStockItems->count() + $outOfStockItems->count() }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $outOfStockItems->count() }} habis, {{ $lowStockItems->count() }} menipis
                    </p>
                </div>
                <div class="w-12 h-12 {{ ($lowStockItems->count() + $outOfStockItems->count()) > 0 ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-500' }} rounded-xl flex items-center justify-center text-xl">
                    ⚠️
                </div>
            </div>
        </div>

        <!-- Warning Section if any low / out of stock -->
        @if ($outOfStockItems->count() > 0 || $lowStockItems->count() > 0)
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xl">⚠️</span>
                    <h3 class="font-bold text-amber-900 text-lg">Peringatan: Stok Barang Mendekati / Mencapai Batas Kritis</h3>
                </div>
                <p class="text-sm text-amber-800 mb-4">Segera lakukan pemesanan ulang (Restock) untuk barang-barang berikut:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach ($outOfStockItems as $item)
                        <div class="bg-white p-3.5 rounded-lg border border-red-200 shadow-xs flex items-center justify-between">
                            <div>
                                <span class="inline-block px-2 py-0.5 text-xs font-bold rounded bg-red-100 text-red-700 mb-1">STOK HABIS (0)</span>
                                <h4 class="font-semibold text-gray-900 text-sm">{{ $item->name }}</h4>
                                <p class="text-xs text-gray-500 font-mono">{{ $item->sku }}</p>
                            </div>
                            <a href="{{ route('movements.create', ['item_id' => $item->id]) }}" class="px-2.5 py-1.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                                + Restock
                            </a>
                        </div>
                    @endforeach

                    @foreach ($lowStockItems as $item)
                        <div class="bg-white p-3.5 rounded-lg border border-amber-200 shadow-xs flex items-center justify-between">
                            <div>
                                <span class="inline-block px-2 py-0.5 text-xs font-bold rounded bg-amber-100 text-amber-800 mb-1">
                                    Sisa {{ $item->stock }} {{ $item->unit }} (Min: {{ $item->min_stock }})
                                </span>
                                <h4 class="font-semibold text-gray-900 text-sm">{{ $item->name }}</h4>
                                <p class="text-xs text-gray-500 font-mono">{{ $item->sku }}</p>
                            </div>
                            <a href="{{ route('movements.create', ['item_id' => $item->id]) }}" class="px-2.5 py-1.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                                + Restock
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent Movements Table -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Aktivitas Mutasi Stok Terkini</h3>
                    <p class="text-sm text-gray-500">Daftar transaksi barang masuk dan keluar terbaru.</p>
                </div>
                <a href="{{ route('movements.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                    Lihat Semua Riwayat &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">Waktu</th>
                            <th scope="col" class="px-6 py-3">Tipe</th>
                            <th scope="col" class="px-6 py-3">Nama Barang</th>
                            <th scope="col" class="px-6 py-3">Jumlah</th>
                            <th scope="col" class="px-6 py-3">No. Referensi / Surat</th>
                            <th scope="col" class="px-6 py-3">Dicatat Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($recentMovements as $mov)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $mov->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($mov->type === 'in')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                            Masuk (In)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                            Keluar (Out)
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <a href="{{ route('items.show', $mov->item) }}" class="hover:text-indigo-600">
                                        {{ $mov->item->name }}
                                    </a>
                                    <span class="block text-xs text-gray-400 font-mono">{{ $mov->item->sku }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                    {{ ($mov->type === 'in' ? '+' : '-') . $mov->quantity }} {{ $mov->item->unit }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-mono">
                                    {{ $mov->reference_number ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600">
                                    {{ $mov->user ? $mov->user->name : 'Sistem' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                    Belum ada catatan mutasi stok.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
