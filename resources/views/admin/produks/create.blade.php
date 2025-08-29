<x-header-admin>
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

            <form action="{{ route('admin.produks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Grid Form -->
                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-teal-600 mr-2"></i> Informasi Produk
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Kode Produk -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Produk <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-barcode text-gray-400"></i>
                                </div>
                                <input type="text" name="kode_produk"
                                    class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                    placeholder="PRD-001">
                            </div>
                        </div>

                        <!-- Nama Produk -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Produk <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-cube text-gray-400"></i>
                                </div>
                                <input type="text" name="nama"
                                    class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                    placeholder="Nama produk">
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                                <select name="kategori_id"
                                    class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Suppliers -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pemasok
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-truck text-gray-400"></i>
                                </div>
                                <select name="suppliers[]"
                                    class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                    multiple>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Gunakan Ctrl untuk memilih multiple</p>
                            </div>
                        </div>

                        <!-- Harga Beli -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Harga Beli (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-arrow-down text-gray-400"></i>
                                </div>
                                <input type="number" name="harga_beli"
                                    class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                    placeholder="0">
                            </div>
                        </div>

                        <!-- Harga Jual -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Harga Jual (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-arrow-up text-gray-400"></i>
                                </div>
                                <input type="number" name="harga_jual"
                                    class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                    placeholder="0">
                            </div>
                        </div>

                        <!-- Stok -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Stok Awal <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-boxes text-gray-400"></i>
                                </div>
                                <input type="number" name="stok"
                                    class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Produk
                        </label>
                        <textarea name="deskripsi"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                            rows="3"
                            placeholder="Deskripsi singkat tentang produk"></textarea>
                    </div>
                </div>

                <!-- Foto Produk Section -->
                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-image text-teal-600 mr-2"></i> Foto Produk
                    </h3>

                    <div class="flex items-center justify-center">
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Unggah Foto
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label class="relative cursor-pointer bg-white rounded-md font-medium text-teal-600 hover:text-teal-500 focus-within:outline-none">
                                            <span>Upload file</span>
                                            <input type="file" name="foto" class="sr-only">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.produks.index') }}"
                        class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors shadow-md flex items-center">
                        <i class="fas fa-save mr-2"></i> Simpan Produk
                    </button>
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

    <x-script-admin />

</x-header-admin>