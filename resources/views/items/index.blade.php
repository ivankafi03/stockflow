<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Data Barang & Inventaris
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola seluruh master data katalog barang dan pantau stok.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('items.export.csv') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg shadow-xs transition">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export CSV
                </a>
                <a href="{{ route('items.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Barang
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <form method="GET" action="{{ route('items.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Search Keyword -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Cari Nama / SKU</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: Lampu, ITM-001..." class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Filter Kategori</label>
                    <select name="category_id" class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Status Stok</label>
                    <select name="status" class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Semua Kondisi</option>
                        <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>Stok Aman</option>
                        <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Stok Menipis (Warning)</option>
                        <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Stok Habis (0)</option>
                    </select>
                </div>

                <!-- Action Button -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold rounded-lg transition">
                        Filter
                    </button>
                    @if (request()->hasAny(['search', 'category_id', 'status']))
                        <a href="{{ route('items.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-lg transition" title="Reset Filter">
                            ✕
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Items Table -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-5 py-3">Barang</th>
                            <th scope="col" class="px-5 py-3">Kategori</th>
                            <th scope="col" class="px-5 py-3">Stok Saat Ini</th>
                            <th scope="col" class="px-5 py-3">Harga Beli</th>
                            <th scope="col" class="px-5 py-3">Harga Jual</th>
                            <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($items as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                            @if ($item->image_url)
                                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-gray-400 text-base">📦</span>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('items.show', $item) }}" class="font-bold text-gray-900 hover:text-indigo-600">
                                                {{ $item->name }}
                                            </a>
                                            <p class="text-xs text-gray-400 font-mono">{{ $item->sku }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 font-medium">
                                        {{ $item->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-base text-gray-900">{{ $item->stock }}</span>
                                        <span class="text-xs text-gray-500">{{ $item->unit }}</span>
                                    </div>
                                    @if ($item->stock <= 0)
                                        <span class="inline-block mt-0.5 px-2 py-0.5 text-xs font-semibold rounded bg-red-100 text-red-700">Habis</span>
                                    @elseif ($item->isLowStock())
                                        <span class="inline-block mt-0.5 px-2 py-0.5 text-xs font-semibold rounded bg-amber-100 text-amber-800">Menipis (Min: {{ $item->min_stock }})</span>
                                    @else
                                        <span class="inline-block mt-0.5 px-2 py-0.5 text-xs font-semibold rounded bg-green-100 text-green-700">Aman</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-800">
                                    Rp {{ number_format($item->cost_price, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-800 font-semibold">
                                    Rp {{ number_format($item->selling_price, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-right space-x-2">
                                    <a href="{{ route('movements.create', ['item_id' => $item->id]) }}" class="px-2.5 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-md transition" title="Mutasi Stok">
                                        ± Stok
                                    </a>
                                    <a href="{{ route('items.show', $item) }}" class="px-2.5 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-md transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('items.edit', $item) }}" class="px-2.5 py-1.5 text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-md transition">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-gray-400">
                                    Tidak ada data barang yang cocok dengan pencarian / filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($items->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
