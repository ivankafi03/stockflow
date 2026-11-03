<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Tambah Barang Baru
                </h2>
                <p class="text-sm text-gray-500 mt-1">Daftarkan item atau aset baru ke dalam sistem katalog.</p>
            </div>
            <a href="{{ route('items.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- SKU Code -->
                    <div>
                        <label for="sku" class="block text-sm font-semibold text-gray-700 mb-1">
                            Kode SKU <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $nextSku) }}" required class="w-full font-mono text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('sku') border-red-500 @enderror">
                        @error('sku')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-400 mt-1">Kode unik identifikasi barang.</p>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" id="category_id" required class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('category_id') border-red-500 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Item Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                        Nama Barang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Lakban Bening 2 Inch 100 Yard" required class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">
                        Deskripsi / Keterangan Spesifikasi
                    </label>
                    <textarea name="description" id="description" rows="3" placeholder="Informasi ukuran, merk, lokasi rak penyimpanan, dll." class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Unit -->
                    <div>
                        <label for="unit" class="block text-sm font-semibold text-gray-700 mb-1">
                            Satuan <span class="text-red-500">*</span>
                        </label>
                        <select name="unit" id="unit" required class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach (['pcs' => 'Pcs (Buah)', 'box' => 'Box / Dus', 'pack' => 'Pack', 'roll' => 'Roll', 'kg' => 'Kilogram (Kg)', 'gram' => 'Gram', 'liter' => 'Liter', 'unit' => 'Unit'] as $key => $label)
                                <option value="{{ $key }}" {{ old('unit') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Cost Price -->
                    <div>
                        <label for="cost_price" class="block text-sm font-semibold text-gray-700 mb-1">
                            Harga Beli / Modal (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="100" min="0" name="cost_price" id="cost_price" value="{{ old('cost_price', 0) }}" required class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Selling Price -->
                    <div>
                        <label for="selling_price" class="block text-sm font-semibold text-gray-700 mb-1">
                            Harga Jual / Nilai (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="100" min="0" name="selling_price" id="selling_price" value="{{ old('selling_price', 0) }}" required class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Initial Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">
                            Stok Awal Fisik <span class="text-red-500">*</span>
                        </label>
                        <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', 0) }}" required class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="text-xs text-gray-400 mt-1">Akan otomatis dicatat sebagai transaksi masuk pertama.</p>
                    </div>

                    <!-- Minimum Stock Threshold -->
                    <div>
                        <label for="min_stock" class="block text-sm font-semibold text-gray-700 mb-1">
                            Batas Stok Minimum (Warning) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" min="0" name="min_stock" id="min_stock" value="{{ old('min_stock', 5) }}" required class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="text-xs text-gray-400 mt-1">Peringatan akan aktif jika stok tersisa sama/kurang dari angka ini.</p>
                    </div>
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Foto Barang (Opsional)
                    </label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP (Maks 2MB).</p>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('items.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
