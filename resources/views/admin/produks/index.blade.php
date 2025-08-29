<x-header-admin>
    @vite('resources/js/app.js')
    <x-navbar />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-4 bg-white rounded-xl shadow-sm border border-gray-200">
                <!-- Search and Filters -->
                <div class="flex flex-col sm:flex-row gap-3 flex-wrap">
                    <!-- Search Input -->
                    <div class="relative flex-1 min-w-[250px]">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-teal-600"></i>
                        </div>
                        <input id="searchNama" type="text" placeholder="Cari produk..."
                            class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                    </div>

                    <!-- Filter Group -->
                    <div class="flex gap-2 flex-wrap">
                        <!-- Kategori Filter -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-teal-600 text-sm"></i>
                            </div>
                            <select id="filterKategori" class="pl-10 border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors min-w-[180px]">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Supplier Filter -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-truck text-teal-600 text-sm"></i>
                            </div>
                            <select id="filterSupplier" class="pl-10 border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors min-w-[180px]">
                                <option value="">Semua Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2 flex-wrap">
                    <!-- Tambah Produk -->
                    <a 
                        id="btnTambahProduk"
                        class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2.5 rounded-lg transition-colors flex items-center gap-2 text-sm font-medium shadow-sm hover:shadow-md">
                        <i class="fas fa-plus-circle"></i>
                        <span>Tambah</span>
                    </a>

                    <!-- Import -->
                    <a href="{{ route('admin.produks.create') }}"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2.5 rounded-lg transition-colors flex items-center gap-2 text-sm font-medium shadow-sm hover:shadow-md">
                        <i class="fas fa-file-import"></i>
                        <span>Import</span>
                    </a>

                    <!-- Kategori -->
                    <a href="{{ route('admin.kategoris.index') }}"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-lg transition-colors flex items-center gap-2 text-sm font-medium shadow-sm hover:shadow-md">
                        <i class="fas fa-tags"></i>
                        <span>Kategori</span>
                    </a>

                    <!-- Supplier -->
                    <a href="{{ route('admin.suppliers.index') }}"
                        class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2.5 rounded-lg transition-colors flex items-center gap-2 text-sm font-medium shadow-sm hover:shadow-md">
                        <i class="fas fa-truck-loading"></i>
                        <span>Supplier</span>
                    </a>
                </div>
            </div>
            <style>
                .transition-colors {
                    transition: all 0.2s ease-in-out;
                }

                .shadow-sm {
                    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                }

                .shadow-md {
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                }

                select {
                    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
                    background-position: right 0.5rem center;
                    background-repeat: no-repeat;
                    background-size: 1.5em 1.5em;
                    padding-right: 2.5rem;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
            </style>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded-lg mb-4 shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        {{-- WRAPPER TABLE --}}
        <div id="produkTableWrapper" class="overflow-x-auto rounded-lg shadow">
            @include('admin.produks._table', ['produks' => $produks])
        </div>


    </div>
    </div>


    {{-- Modal Tambah Stok --}}
    <div id="stokModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow-md w-96">
            <h3 class="text-lg font-bold mb-4">Tambah Stok</h3>
            <form id="stokForm">
                @csrf
                <input type="hidden" id="stokProdukId" name="produk_id">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Jumlah Stok</label>
                    <input type="number" id="jumlahStok" name="stok" min="1"
                        class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="btnCancelStok"
                        class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Create/Edit Produk -->
    <div id="produkModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-[900px] max-h-[90vh] overflow-y-auto p-6">
            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 id="produkModalTitle" class="text-xl font-semibold text-gray-800">Tambah Produk</h3>
                <button onclick="closeProdukModal()" class="text-gray-500 hover:text-gray-800">
                    ✕
                </button>
            </div>

            <!-- Form -->
            <form id="produkForm" class="grid grid-cols-2 gap-6" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="produkIdField" name="id">
                <input type="hidden" name="_method" id="methodField" value="POST">

                <!-- Kolom Kiri -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Produk</label>
                        <input type="text" id="kode_produk" name="kode_produk"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200" required maxlength="100">
                        <small class="text-red-500 hidden" id="kode-error">Kode produk sudah digunakan</small>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" id="nama" name="nama"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200" required maxlength="255">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select id="kategori_id" name="kategori_id"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga Beli</label>
                            <input type="number" id="harga_beli" name="harga_beli"
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200" required min="0" step="1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga Jual</label>
                            <input type="number" id="harga_jual" name="harga_jual"
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200" required min="0" step="1">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" id="stok" name="stok"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200" required min="0">
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Supplier</label>
                        <select id="suppliers" name="suppliers[]" multiple
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200" required>
                            @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                            @endforeach
                        </select>
                        <small class="text-gray-500">Pilih satu atau lebih supplier</small>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200" rows="4"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Foto Produk</label>
                        <input type="file" id="foto" name="foto"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200"
                            accept="image/jpeg,image/jpg,image/png">
                        <small class="text-gray-500">Format: JPG, JPEG, PNG (Max: 2MB)</small>
                    </div>
                </div>

                <!-- Footer -->
                <div class="col-span-2 flex justify-end gap-3 pt-4 border-t">
                    <button type="button" id="btnCancelProduk"
                        class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700"
                        id="submitBtn">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>


    <x-script-admin />
    <script>

    </script>


</x-header-admin>