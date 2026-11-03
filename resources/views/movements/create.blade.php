<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Catat Transaksi Mutasi Stok
                </h2>
                <p class="text-sm text-gray-500 mt-1">Input data barang masuk (restock) atau barang keluar (pemakaian / penjualan).</p>
            </div>
            <a href="{{ route('movements.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition">
                &larr; Riwayat Mutasi
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 sm:p-8" x-data="{
            selectedItemId: '{{ old('item_id', $selectedItemId ?? '') }}',
            movementType: '{{ old('type', 'in') }}',
            items: {{ $items->toJson() }},
            get selectedItem() {
                return this.items.find(i => i.id == this.selectedItemId) || null;
            }
        }">
            <form action="{{ route('movements.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Movement Type Selector -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Pilih Jenis Mutasi <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer border rounded-xl p-4 flex items-center gap-3 transition" :class="movementType === 'in' ? 'border-green-500 bg-green-50/60 ring-2 ring-green-200' : 'border-gray-200 hover:bg-gray-50'">
                            <input type="radio" name="type" value="in" x-model="movementType" class="text-green-600 focus:ring-green-500">
                            <div>
                                <span class="font-bold text-green-900 text-sm block">Barang Masuk (+ In)</span>
                                <span class="text-xs text-green-700">Restock dari supplier / pengadaan</span>
                            </div>
                        </label>

                        <label class="cursor-pointer border rounded-xl p-4 flex items-center gap-3 transition" :class="movementType === 'out' ? 'border-rose-500 bg-rose-50/60 ring-2 ring-rose-200' : 'border-gray-200 hover:bg-gray-50'">
                            <input type="radio" name="type" value="out" x-model="movementType" class="text-rose-600 focus:ring-rose-500">
                            <div>
                                <span class="font-bold text-rose-900 text-sm block">Barang Keluar (- Out)</span>
                                <span class="text-xs text-rose-700">Pemakaian operasional / penjualan</span>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Item Selector -->
                <div>
                    <label for="item_id" class="block text-sm font-semibold text-gray-700 mb-1">
                        Pilih Barang <span class="text-red-500">*</span>
                    </label>
                    <select name="item_id" id="item_id" x-model="selectedItemId" required class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('item_id') border-red-500 @enderror">
                        <option value="">-- Pilih Barang yang Akan Dimutasi --</option>
                        @foreach ($items as $itm)
                            <option value="{{ $itm->id }}" {{ old('item_id', $selectedItemId) == $itm->id ? 'selected' : '' }}>
                                {{ $itm->name }} (SKU: {{ $itm->sku }}) — Stok Tersedia: {{ $itm->stock }} {{ $itm->unit }}
                            </option>
                        @endforeach
                    </select>
                    @error('item_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Selected item preview badge -->
                    <template x-if="selectedItem">
                        <div class="mt-2.5 p-3 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-between text-xs">
                            <span class="text-gray-600">
                                Stok saat ini: <strong class="text-gray-900" x-text="selectedItem.stock + ' ' + selectedItem.unit"></strong>
                            </span>
                            <span class="text-gray-500 font-mono" x-text="'SKU: ' + selectedItem.sku"></span>
                        </div>
                    </template>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-1">
                            Jumlah Unit <span class="text-red-500">*</span>
                        </label>
                        <input type="number" min="1" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" required class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('quantity') border-red-500 @enderror">
                        @error('quantity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reference Number -->
                    <div>
                        <label for="reference_number" class="block text-sm font-semibold text-gray-700 mb-1">
                            No. Referensi / Surat Jalan / PO
                        </label>
                        <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number') }}" placeholder="Contoh: PO-2026/11/001, SJ-889" class="w-full text-sm font-mono rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="text-xs text-gray-400 mt-1">Opsional, nomor bukti transaksi fisik.</p>
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">
                        Catatan / Keterangan Transaksi
                    </label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Contoh: Pengiriman batch 1 dari supplier CV Maju, atau Pengambilan bahan untuk divisi produksi." class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('movements.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
