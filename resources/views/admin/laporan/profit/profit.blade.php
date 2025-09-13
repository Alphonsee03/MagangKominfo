<x-header-admin title="Laporan Profit">
    <x-navbar />
    <x-topheader />
    <div class="pc-container">
        <div class="pc-content">
            <div class="p-6 space-y-6 -mt-8">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                        <div class="bg-teal-600 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        Laporan Profit
                    </h2>
                    <button id="btn-export" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-5 py-2.5 rounded-lg hover:from-red-600 hover:to-red-700 transition-all flex items-center shadow-md mt-4 sm:mt-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export PDF
                    </button>
                </div>

                <!-- Filter Section -->
                <div class="bg-gradient-to-r from-teal-50 to-blue-50 rounded-xl p-5 border border-teal-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-teal-800 mb-1">Tanggal Mulai</label>
                            <input type="date" id="start_date" class="w-full border border-teal-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-teal-800 mb-1">Tanggal Akhir</label>
                            <input type="date" id="end_date" class="w-full border border-teal-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        <div class="flex items-end">
                            <button id="btn-filter" class="bg-teal-600 text-white px-4 py-2.5 rounded-lg hover:bg-teal-700 transition-colors w-full">
                                Terapkan Filter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg text-white font-semibold opacity-90">Total Penjualan</h4>
                                <p id="total-penjualan" class="text-md font-bold mt-1">Rp 0</p>
                            </div>
                            <div class="bg-white/20 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-5 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg text-white font-semibold opacity-90">Total Modal</h4>
                                <p id="total-modal" class="text-md font-bold mt-1">Rp 0</p>
                            </div>
                            <div class="bg-white/20 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg text-white font-semibold opacity-90">Profit Bersih</h4>
                                <p id="total-profit" class="text-md font-bold mt-1">Rp 0</p>
                            </div>
                            <div class="bg-white/20 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-5 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg text-white font-semibold opacity-90">Total transaksi</h4>
                                <p id="total-transaksi" class="text-md font-bold mt-1">Tidak ada transaksi</p>
                            </div>
                            <div class="bg-white/20 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="w-full text-md">
                            <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
                                <tr>
                                    <th class="p-4 text-center font-semibold">Invoice</th>
                                    <th class="p-4 text-center font-semibold">Tanggal</th>
                                    <th class="p-4 text-center font-semibold">Kasir</th>
                                    <th class="p-4 text-center font-semibold">Produk</th>
                                    <th class="p-4 text-center font-semibold">Qty</th>
                                    <th class="p-4 text-center font-semibold">Harga Beli</th>
                                    <th class="p-4 text-center font-semibold">Harga Jual</th>
                                    <th class="p-4 text-center font-semibold">Subtotal</th>
                                    <th class="p-4 text-center font-semibold">Profit</th>
                                </tr>
                            </thead>
                            <tbody id="table-body" class="divide-y divide-gray-100"></tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    <div id="empty-state" class="hidden py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data profit</h3>
                        <p class="mt-1 text-sm text-gray-500">Coba ubah filter tanggal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/admin-laporan-profit.js') }}"></script>
    <x-script-admin />
</x-header-admin>