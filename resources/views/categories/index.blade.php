<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Kategori Barang
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelompokkan barang inventaris untuk memudahkan pencarian dan pelaporan.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Tambah Kategori -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 h-fit">
                <h3 class="font-bold text-gray-900 text-base mb-1">Tambah Kategori Baru</h3>
                <p class="text-xs text-gray-500 mb-4">Buat label pengelompokan baru.</p>

                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-xs font-semibold text-gray-700 mb-1">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" placeholder="Contoh: Elektronik, ATK, Bahan Baku..." required class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-semibold text-gray-700 mb-1">
                            Keterangan (Opsional)
                        </label>
                        <textarea name="description" id="description" rows="3" placeholder="Deskripsi ringkas kegunaan kategori..." class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        + Tambah Kategori
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Kategori -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 text-base">Daftar Kategori Terdaftar</h3>
                    <p class="text-xs text-gray-500">Total {{ $categories->total() }} kategori aktif.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-5 py-3">Nama Kategori</th>
                                <th scope="col" class="px-5 py-3">Keterangan</th>
                                <th scope="col" class="px-5 py-3 text-center">Jumlah Barang</th>
                                <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($categories as $cat)
                                <tr class="hover:bg-gray-50" x-data="{ editing: false, name: '{{ addslashes($cat->name) }}', description: '{{ addslashes($cat->description) }}' }">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div x-show="!editing">
                                            <span class="font-bold text-gray-900">{{ $cat->name }}</span>
                                            <span class="block text-xs text-gray-400 font-mono">{{ $cat->slug }}</span>
                                        </div>
                                        <div x-show="editing" x-cloak>
                                            <form id="edit-cat-{{ $cat->id }}" action="{{ route('categories.update', $cat) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="name" x-model="name" required class="text-xs rounded border-gray-300 w-full mb-1">
                                                <input type="text" name="description" x-model="description" placeholder="Deskripsi..." class="text-xs rounded border-gray-300 w-full">
                                            </form>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-xs text-gray-500">
                                        <span x-show="!editing">{{ $cat->description ?: '-' }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-center whitespace-nowrap">
                                        <a href="{{ route('items.index', ['category_id' => $cat->id]) }}" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 hover:bg-indigo-100">
                                            {{ $cat->items_count }} item
                                        </a>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-right space-x-1">
                                        <template x-if="!editing">
                                            <div class="inline-flex items-center gap-1">
                                                <button @click="editing = true" class="px-2.5 py-1 text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-md">
                                                    Edit
                                                </button>
                                                <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-md">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </template>
                                        <template x-if="editing">
                                            <div class="inline-flex items-center gap-1">
                                                <button form="edit-cat-{{ $cat->id }}" type="submit" class="px-2.5 py-1 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 rounded-md">
                                                    Simpan
                                                </button>
                                                <button @click="editing = false" type="button" class="px-2.5 py-1 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                                                    Batal
                                                </button>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-gray-400">
                                        Belum ada kategori yang dibuat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($categories->hasPages())
                    <div class="p-4 border-t border-gray-100">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
