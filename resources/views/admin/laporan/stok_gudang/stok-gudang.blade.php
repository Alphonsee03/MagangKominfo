<x-header-admin>
    <x-navbar />
    <x-topheader />
    <div class="pc-container">
        <div class="pc-content">
            <div class="p-6 space-y-6">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                        <div class="bg-teal-600 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        Laporan Stok Gudang
                    </h2>
                    <span class="text-sm text-gray-500 mt-2 sm:mt-0" id="total-items">0 produk</span>
                </div>

                <!-- Filter Section -->
                <div class="bg-gradient-to-r from-teal-50 to-blue-50 rounded-xl p-5 border border-teal-100">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-4 space-y-3 lg:space-y-0">
                        <!-- Supplier Filter -->
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <select id="supplier_id" class="pl-10 border border-gray-300 rounded-lg px-4 py-2.5 w-full focus:ring-2 focus:ring-teal-500 focus:border-teal-500 appearance-none transition-colors">
                                <option value="">Semua Supplier</option>
                                @foreach($suppliers as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Export Button -->
                        <button id="btn-export" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-5 py-2.5 rounded-lg hover:from-red-600 hover:to-red-700 transition-all flex items-center shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export PDF
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
                                <tr>
                                    <th class="p-4 text-center font-semibold">No.</th>
                                    <th class="p-4 text-center font-semibold">Kode</th>
                                    <th class="p-4 text-center font-semibold">Nama Produk</th>
                                    <th class="p-4 text-center font-semibold">Stok</th>
                                    <th class="p-4 text-right font-semibold">Harga Beli</th>
                                    <th class="p-4 text-right font-semibold">Harga Jual</th>
                                    <th class="p-4 text-right font-semibold">Nilai Stok</th>
                                    <th class="p-4 text-center font-semibold">Supplier</th>
                                </tr>
                            </thead>
                            <tbody id="stok-body" class="divide-y divide-gray-100"></tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    <div id="empty-state" class="hidden py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-16"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data stok</h3>
                        <p class="mt-1 text-sm text-gray-500">Coba ubah filter supplier Anda.</p>
                    </div>
                </div>

                <!-- Summary -->
                <div class="bg-teal-50 rounded-xl p-5 border border-teal-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        <div>
                            <p class="text-sm text-teal-700 font-medium">Total Nilai Stok</p>
                            <p class="text-xl font-bold text-teal-800" id="total-nilai">Rp 0</p>
                        </div>
                        <div>
                            <p class="text-sm text-teal-700 font-medium">Total Produk</p>
                            <p class="text-xl font-bold text-teal-800" id="total-produk">0</p>
                        </div>
                        <div>
                            <p class="text-sm text-teal-700 font-medium">Rata-rata Stok</p>
                            <p class="text-xl font-bold text-teal-800" id="rata-stok">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/admin-stok-gudang.js') }}"></script>
    <x-script-admin />
</x-header-admin>