<x-header-admin title="Daftar Transaksi">

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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        Daftar Transaksi
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
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-teal-800 mb-1">Tanggal Mulai</label>
                            <input type="date" id="start_date" class="w-full border border-teal-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-teal-800 mb-1">Tanggal Akhir</label>
                            <input type="date" id="end_date" class="w-full border border-teal-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-teal-800 mb-1">Metode Bayar</label>
                            <select id="metode" class="w-full border border-teal-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                <option value="">Semua Metode</option>
                                <option value="cash">Cash</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-teal-800 mb-1">Pencarian</label>
                            <input type="text" id="search" placeholder="Cari invoice / pelanggan / kasir"
                                class="w-full border border-teal-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
                                <tr>
                                    <th class="p-4 text-md text-center font-semibold">Tanggal</th>
                                    <th class="p-4 text-md text-center font-semibold">Invoice</th>
                                    <th class="p-4 text-md text-center font-semibold">Kasir</th>
                                    <th class="p-4 text-md text-center font-semibold">Pelanggan</th>
                                    <th class="p-4 text-md text-center font-semibold">Total</th>
                                    <th class="p-4 text-md text-center font-semibold">Bayar</th>
                                    <th class="p-4 text-md text-center font-semibold">Metode</th>
                                    <th class="p-4 text-md text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-body" class="divide-y divide-gray-100"></tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-2">
                    <div class="text-sm text-gray-600 mb-2 sm:mb-0">
                        Menampilkan <span id="page-start">0</span> - <span id="page-end">0</span> dari <span id="total-count">0</span> transaksi
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

            <!-- Modal Detail -->
            <div id="modal-detail" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 translate-y-10">
                <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl max-h-[90vh] overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-white">Detail Transaksi</h3>
                            <button  class="text-white hover:text-teal-200 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-6 overflow-y-auto max-h-[70vh]">
                        <div id="detail-body" class="space-y-4"></div>
                    </div>

                    <div class="flex justify-end gap-3 p-6 border-t border-teal-200 bg-teal-50">
                        <button id="btn-print" class="px-5 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 text-white rounded-lg hover:from-teal-700 hover:to-teal-800 transition-all flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2z" />
                            </svg>
                            Export Detail PDF
                        </button>
                        <button id="close-detail" class="px-5 py-2.5 border border-teal-300 text-teal-700 rounded-lg hover:bg-teal-50 transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="{{ asset('assets/js/admin-transaksi.js') }}"></script>
    <x-script-admin />


</x-header-admin>