<x-header-admin>
    @vite('resources/js/create-produk.js')
    <x-navbar />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">
            <!-- Header Section -->
            <div class="mb-6">
                <div class="flex items-center mb-2">
                    <a href="{{ route('admin.produks.index') }}" class="text-teal-600 hover:text-teal-800 mr-3">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="text-2xl font-bold text-teal-600">Tambah Produk Baru</h2>
                </div>
                <p class="text-gray-500 ml-7">Lengkapi form berikut untuk menambahkan produk baru</p>
                <div class="border-b border-gray-200 mt-4"></div>
            </div>

            {{-- Alert --}}
            <div id="alertBox" class="hidden px-4 py-3 rounded-lg mb-4 text-white"></div>

            <form action="{{ route('admin.produks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div id="produk-wrapper">
                    <div class="bg-teal-100 rounded-xl border border-teal-300 p-3 shadow-sm">
                        <!-- Header -->
                        <div class="flex bg-gradient-to-r from-teal-50 to-teal-100 rounded-lg p-4 -mx-2 -mt-2 mb-6">
                            <h3 class="text-lg font-semibold text-teal-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Informasi Produk
                            </h3>

                        </div>

                        <!-- Row 1: Kode & Nama Produk -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-3">
                            <!-- Kode Produk -->
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-teal-700 mb-2">Kode Produk <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="text" name="products[0][kode_produk]"
                                        class="w-full border border-teal-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                        placeholder="0000000000000" required>
                                </div>
                            </div>

                            <!-- Nama Produk -->
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-teal-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                                <input type="text" name="products[0][nama]"
                                    class="w-full border border-teal-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                    placeholder="Nama produk lengkap" required>
                            </div>
                        </div>

                        <!-- Row 2: Kategori, Harga Beli, Harga Jual -->
                        <div class="grid grid-cols-1 md:grid-cols-8 gap-4 mt-4">
                            <!-- Kategori -->
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-teal-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="products[0][kategori_id]"
                                        class="w-full border border-teal-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors appearance-none" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Harga Beli -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-teal-700 mb-2">Harga Beli <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                    <input type="number" name="products[0][harga_beli]"
                                        class="w-full border border-teal-200 rounded-lg pl-10 pr-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                        placeholder="0" min="0">
                                </div>
                            </div>

                            <!-- Harga Jual -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-teal-700 mb-2">Harga Jual <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                    <input type="number" name="products[0][harga_jual]"
                                        class="w-full border border-teal-200 rounded-lg pl-10 pr-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                        placeholder="0" min="0">
                                </div>
                            </div>

                            <!-- Stok -->
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-teal-700 mb-2">Stok Awal <span class="text-red-500">*</span></label>
                                <input type="number" name="products[0][stok]"
                                    class="w-full border border-teal-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                    placeholder="0" min="0">
                            </div>

                        </div>

                        <!-- Row 3: Supplier & Stok -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <!-- Supplier -->
                            <div>
                                <label class="block text-sm font-medium text-teal-700 mb-2">Pemasok <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="products[0][suppliers][]"
                                        class="w-full border border-teal-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors h-32" multiple>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-xs text-teal-600 mt-2">⌘/Ctrl + klik untuk memilih multiple</p>
                            </div>

                            <!-- Deskripsi -->
                            <div class="mt-4 h-full">
                                <label class="block text-sm font-medium text-teal-700 mb-2">Deskripsi Produk</label>
                                <textarea name="products[0][deskripsi]" rows="3"
                                    class="w-full border border-teal-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                    placeholder="Deskripsi singkat tentang produk..."></textarea>
                            </div>

                        </div>

                        <!-- Foto -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-teal-700 mb-2">Foto Produk</label>
                            <div class="border-2 border-dashed border-teal-200 rounded-lg p-6 text-center hover:border-teal-300 transition-colors cursor-pointer">
                                <input type="file" name="products[0][foto]"
                                    class=" opacity-0 w-full h-full cursor-pointer"
                                    accept="image/jpeg,image/jpg,image/png">
                                <div class="pointer-events-none">
                                    <svg class="w-12 h-12 text-teal-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm text-teal-600">Klik untuk upload foto</p>
                                    <p class="text-xs text-teal-500 mt-1">JPG, PNG (Maks: 2MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-6 border-t border-teal-400">
                    <a href="{{ route('admin.produks.index') }}"
                        class="px-6 py-3 border border-teal-300 text-teal-700 rounded-lg hover:bg-teal-50 transition-colors font-medium">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-700 text-white rounded-lg hover:from-teal-700 hover:to-teal-800 transition-all shadow-md font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Produk
                    </button>

                    <div class="hidden ">
                        <button type="button" id="add-product" class="px-2 py-1 text-white bg-teal-800 rounded-lg hover:bg-teal-900 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>

                

                

            </form>

        </div>
    </div>


    <style>
        .transition-colors {
            transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
        }

        select[multiple] {
            height: auto;
            min-height: 120px;
        }
    </style>

    <script>
        
    </script>
    <x-script-admin />

</x-header-admin>