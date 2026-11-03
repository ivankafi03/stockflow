<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Riwayat Transaksi Mutasi Stok
                </h2>
                <p class="text-sm text-gray-500 mt-1">Audit log pergerakan barang masuk (restock) dan barang keluar (pemakaian/penjualan).</p>
            </div>
            <a href="{{ route('movements.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Catat Transaksi Baru
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <form method="GET" action="{{ route('movements.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <!-- Filter Type -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tipe Mutasi</label>
                    <select name="type" class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Semua Tipe (Masuk & Keluar)</option>
                        <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Barang Masuk (+ In)</option>
                        <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Barang Keluar (- Out)</option>
                    </select>
                </div>

                <!-- Filter Item -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Filter Barang</label>
                    <select name="item_id" class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Semua Barang</option>
                        @foreach ($items as $itm)
                            <option value="{{ $itm->id }}" {{ request('item_id') == $itm->id ? 'selected' : '' }}>
                                {{ $itm->name }} ({{ $itm->sku }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit & Reset -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold rounded-lg transition">
                        Terapkan Filter
                    </button>
                    @if (request()->hasAny(['type', 'item_id']))
                        <a href="{{ route('movements.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-lg transition">
                            ✕
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-5 py-3">Waktu</th>
                            <th scope="col" class="px-5 py-3">Tipe</th>
                            <th scope="col" class="px-5 py-3">Barang</th>
                            <th scope="col" class="px-5 py-3">Jumlah</th>
                            <th scope="col" class="px-5 py-3">No. Referensi</th>
                            <th scope="col" class="px-5 py-3">Keterangan / Catatan</th>
                            <th scope="col" class="px-5 py-3">Operator</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($movements as $m)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $m->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if ($m->type === 'in')
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
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <a href="{{ route('items.show', $m->item) }}" class="font-bold text-gray-900 hover:text-indigo-600">
                                        {{ $m->item->name }}
                                    </a>
                                    <span class="block text-xs text-gray-400 font-mono">{{ $m->item->sku }}</span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap font-bold text-base {{ $m->type === 'in' ? 'text-green-600' : 'text-rose-600' }}">
                                    {{ ($m->type === 'in' ? '+' : '-') . $m->quantity }} <span class="text-xs font-normal text-gray-500">{{ $m->item->unit }}</span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap font-mono text-xs text-gray-600">
                                    {{ $m->reference_number ?: '-' }}
                                </td>
                                <td class="px-5 py-4 text-xs text-gray-600 max-w-xs truncate">
                                    {{ $m->notes ?: '-' }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $m->user ? $m->user->name : 'Sistem' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-gray-400">
                                    Belum ada data transaksi yang sesuai filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($movements->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $movements->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
