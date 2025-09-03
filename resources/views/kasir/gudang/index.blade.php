<x-header_kasir>
    @vite('resources/js/kasir-stok.js')
    <x-navbar_kasir />
    <x-topheader />
    <div class="pc-container">
        <div class="pc-content">
            <div class="p-6 space-y-6 -mt-10">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center mb-4 sm:mb-0">
                        <div class="bg-teal-600 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        Stok Produk
                    </h2>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500" id="total-items">0 produk</span>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="bg-gradient-to-r from-teal-200 to-blue-300 rounded-xl p-5 border border-teal-500">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-4 space-y-3 lg:space-y-0">
                        <!-- Search -->
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="search" placeholder="Cari kode / nama produk..."
                                class="pl-10 border border-gray-300 rounded-lg px-4 py-2.5 w-full focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                        </div>

                        <!-- Dropdown Supplier -->
                        <div class="relative lg:w-1/3">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <select id="filter-supplier" class="pl-10 border border-gray-300 rounded-lg px-4 py-2.5 w-full focus:ring-2 focus:ring-teal-500 focus:border-teal-500 appearance-none transition-colors">
                                <option value="">Semua Supplier</option>
                                @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
                                <tr>
                                    <th class="p-4 text-center font-semibold">Kode Produk</th>
                                    <th class="p-4 text-center font-semibold">Nama</th>
                                    <th class="p-4 text-center font-semibold">Stok</th>
                                    <th class="p-4 text-center font-semibold">Harga Jual</th>
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
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada produk</h3>
                        <p class="mt-1 text-sm text-gray-500">Coba ubah filter pencarian Anda.</p>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-2">
                    <div class="text-sm text-gray-600 mb-2 sm:mb-0">
                        Menampilkan <span id="page-start">0</span> - <span id="page-end">0</span> dari <span id="total-count">0</span> produk
                    </div>
                    <div class="flex items-center space-x-2">
                        <button id="prev-page" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Prev
                        </button>
                        <span class="text-sm text-gray-700 font-medium" id="page-info">Halaman 1</span>
                        <button id="next-page" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center">
                            Next
                            <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <x-script-admin />
</x-header_kasir>