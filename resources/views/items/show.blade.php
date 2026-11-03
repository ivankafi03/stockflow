<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 font-semibold uppercase">
                        {{ $item->category->name ?? '-' }}
                    </span>
                    <span class="text-xs font-mono text-gray-500 font-bold">{{ $item->sku }}</span>
                </div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight mt-1">
                    {{ $item->name }}
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('movements.create', ['item_id' => $item->id]) }}" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                    ± Catat Mutasi
                </a>
                <a href="{{ route('items.edit', $item) }}" class="px-3.5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                    Edit Barang
                </a>
                <form action="{{ route('items.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 text-sm font-semibold rounded-lg transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Main Info Card -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Image or Placeholder -->
                <div class="flex flex-col items-center justify-center bg-gray-50 rounded-xl border border-gray-200 p-4 aspect-square max-h-72 overflow-hidden">
                    @if ($item->image_url)
                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-contain">
                    @else
                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <p class="text-xs text-slate-400 mt-2 font-medium">Dokumentasi Visual Belum Tersedia</p>
                    @endif
                </div>

                <!-- Info details -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Stock Status Banner -->
                    <div class="p-4 rounded-xl {{ $item->stock <= 0 ? 'bg-red-50 border border-red-200' : ($item->isLowStock() ? 'bg-amber-50 border border-amber-200' : 'bg-emerald-50 border border-emerald-200') }} flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider {{ $item->stock <= 0 ? 'text-red-700' : ($item->isLowStock() ? 'text-amber-800' : 'text-emerald-700') }}">
                                Status Ketersediaan Fisik
                            </p>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-3xl font-extrabold {{ $item->stock <= 0 ? 'text-red-700' : ($item->isLowStock() ? 'text-amber-900' : 'text-emerald-900') }}">
                                    {{ $item->stock }}
                                </span>
                                <span class="text-sm font-semibold text-gray-600">{{ $item->unit }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-gray-500 block">Ambang Batas Minimum</span>
                            <span class="font-bold text-sm text-gray-700">{{ $item->min_stock }} {{ $item->unit }}</span>
                        </div>
                    </div>

                    <!-- Pricing Info Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <span class="text-xs text-gray-500">Harga Beli (Modal)</span>
                            <p class="text-lg font-bold text-gray-900 mt-1">Rp {{ number_format($item->cost_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <span class="text-xs text-gray-500">Harga Jual / Nilai</span>
                            <p class="text-lg font-bold text-indigo-600 mt-1">Rp {{ number_format($item->selling_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg col-span-2 sm:col-span-1">
                            <span class="text-xs text-gray-500">Estimasi Total Valuasi</span>
                            <p class="text-lg font-bold text-emerald-600 mt-1">Rp {{ number_format($item->stock * $item->cost_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Keterangan / Spesifikasi</h4>
                        <p class="text-sm text-gray-700 mt-1 whitespace-pre-line leading-relaxed">
                            {{ $item->description ?: 'Tidak ada keterangan tambahan.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Movement History for this Item -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Riwayat Keluar Masuk Barang Ini</h3>
                    <p class="text-sm text-gray-500">Audit trail pergerakan stok untuk {{ $item->name }}.</p>
                </div>
                <a href="{{ route('movements.create', ['item_id' => $item->id]) }}" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-md">
                    + Catat Transaksi Baru
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">Waktu</th>
                            <th scope="col" class="px-6 py-3">Tipe</th>
                            <th scope="col" class="px-6 py-3">Jumlah</th>
                            <th scope="col" class="px-6 py-3">No. Referensi</th>
                            <th scope="col" class="px-6 py-3">Catatan / Keterangan</th>
                            <th scope="col" class="px-6 py-3">Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($item->stockMovements as $mov)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $mov->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($mov->type === 'in')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            Masuk (+ In)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                            Keluar (- Out)
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                    {{ ($mov->type === 'in' ? '+' : '-') . $mov->quantity }} {{ $item->unit }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-gray-600">
                                    {{ $mov->reference_number ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-600">
                                    {{ $mov->notes ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $mov->user->name ?? 'Sistem' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                    Belum ada catatan mutasi stok untuk barang ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
