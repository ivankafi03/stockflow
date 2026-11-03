<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-900 tracking-tight">
                    Executive Dashboard
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Ringkasan kondisi inventaris dan pergerakan stok logistik.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('items.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-md shadow-xs transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Pendaftaran Item
                </a>
                <a href="{{ route('movements.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-md shadow-xs transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    Catat Mutasi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- 4 Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total SKU Item -->
            <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Item Barang</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($totalItems) }}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $totalCategories }} Kategori Aktif</p>
                </div>
                <div class="w-10 h-10 bg-slate-100 text-slate-700 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>

            <!-- Total Physical Units -->
            <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Kuantitas Fisik</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($totalStockQty) }}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Unit Persediaan Riil</p>
                </div>
                <div class="w-10 h-10 bg-blue-50 text-blue-700 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>

            <!-- Total Asset Valuation -->
            <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Valuasi Persediaan</p>
                    <p class="text-xl font-bold text-slate-900 mt-1">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Basis Nilai Perolehan</p>
                </div>
                <div class="w-10 h-10 bg-emerald-50 text-emerald-700 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>

            <!-- Status Alert Card -->
            <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs flex items-center justify-between {{ ($lowStockItems->count() + $outOfStockItems->count()) > 0 ? 'border-amber-300 bg-amber-50/30' : '' }}">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Perhatian Khusus</p>
                    <p class="text-2xl font-bold {{ ($lowStockItems->count() + $outOfStockItems->count()) > 0 ? 'text-amber-700' : 'text-slate-900' }} mt-1">
                        {{ $lowStockItems->count() + $outOfStockItems->count() }}
                    </p>
                    <p class="text-[11px] text-slate-400 mt-0.5">
                        {{ $outOfStockItems->count() }} Habis, {{ $lowStockItems->count() }} Menipis
                    </p>
                </div>
                <div class="w-10 h-10 {{ ($lowStockItems->count() + $outOfStockItems->count()) > 0 ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600' }} rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
        </div>

        <!-- Warning Section if any low / out of stock -->
        @if ($outOfStockItems->count() > 0 || $lowStockItems->count() > 0)
            <div class="bg-white border-l-4 border-amber-500 border-y border-r border-slate-200 rounded-r-lg p-5 shadow-xs">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <h3 class="font-bold text-slate-900 text-sm tracking-tight uppercase">Peringatan Pengawasan: Persediaan Mendekati / Mencapai Ambang Batas Kritis</h3>
                    </div>
                </div>
                <p class="text-xs text-slate-600 mb-4">Daftar item berikut memerlukan pengadaan ulang (restock) segera untuk menjaga kontinuitas operasional:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach ($outOfStockItems as $item)
                        <div class="bg-slate-50 p-3 rounded border border-rose-200 flex items-center justify-between">
                            <div>
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded bg-rose-100 text-rose-800 mb-1">STOK HABIS (0)</span>
                                <h4 class="font-semibold text-slate-900 text-xs">{{ $item->name }}</h4>
                                <p class="text-[10px] text-slate-500 font-mono">{{ $item->sku }}</p>
                            </div>
                            <a href="{{ route('movements.create', ['item_id' => $item->id]) }}" class="px-2.5 py-1 text-xs font-semibold text-white bg-slate-900 hover:bg-slate-800 rounded">
                                Restock
                            </a>
                        </div>
                    @endforeach

                    @foreach ($lowStockItems as $item)
                        <div class="bg-slate-50 p-3 rounded border border-amber-200 flex items-center justify-between">
                            <div>
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded bg-amber-100 text-amber-900 mb-1">
                                    Sisa: {{ $item->stock }} {{ $item->unit }} (Min: {{ $item->min_stock }})
                                </span>
                                <h4 class="font-semibold text-slate-900 text-xs">{{ $item->name }}</h4>
                                <p class="text-[10px] text-slate-500 font-mono">{{ $item->sku }}</p>
                            </div>
                            <a href="{{ route('movements.create', ['item_id' => $item->id]) }}" class="px-2.5 py-1 text-xs font-semibold text-white bg-slate-900 hover:bg-slate-800 rounded">
                                Restock
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent Movements Table -->
        <div class="bg-white rounded-lg border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wider">Audit Log Mutasi Persediaan Terkini</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Rekapitulasi pencatatan transaksi masuk dan keluar terakhir.</p>
                </div>
                <a href="{{ route('movements.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                    Buka Seluruh Riwayat Log &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-slate-600">
                    <thead class="text-[11px] text-slate-700 uppercase bg-slate-50 border-b border-slate-200 font-semibold tracking-wider">
                        <tr>
                            <th scope="col" class="px-5 py-3">Timestamp</th>
                            <th scope="col" class="px-5 py-3">Tipe Transaksi</th>
                            <th scope="col" class="px-5 py-3">Deskripsi Item</th>
                            <th scope="col" class="px-5 py-3">Kuantitas</th>
                            <th scope="col" class="px-5 py-3">Nomor Referensi</th>
                            <th scope="col" class="px-5 py-3">Personil Bertugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentMovements as $mov)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-5 py-3.5 whitespace-nowrap text-slate-500 font-mono">
                                    {{ $mov->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if ($mov->type === 'in')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase tracking-wider">
                                            Inbound (+ Masuk)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 uppercase tracking-wider">
                                            Outbound (- Keluar)
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 font-medium text-slate-900 whitespace-nowrap">
                                    <a href="{{ route('items.show', $mov->item) }}" class="hover:text-blue-600">
                                        {{ $mov->item->name }}
                                    </a>
                                    <span class="block text-[11px] text-slate-400 font-mono">{{ $mov->item->sku }}</span>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap font-bold text-slate-900">
                                    {{ ($mov->type === 'in' ? '+' : '-') . $mov->quantity }} {{ $mov->item->unit }}
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap font-mono text-slate-600">
                                    {{ $mov->reference_number ?? '-' }}
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-slate-600">
                                    {{ $mov->user ? $mov->user->name : 'System Automated' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                                    Tidak ada catatan transaksi mutasi dalam basis data.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
