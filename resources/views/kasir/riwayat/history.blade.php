<x-header_kasir>
    @vite('resources/js/kasir-history.js')
    <x-navbar_kasir />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">
            <div class="p-6 space-y-6">

                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h1>
                        <p class="text-gray-500">Daftar semua transaksi yang telah dilakukan</p>
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter
                        </button>
                        <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export
                        </button>
                    </div>
                </div>

                <!-- Tabel Riwayat -->
                <div class="bg-white shadow rounded-xl overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Daftar Transaksi
                        </h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left" id="table-riwayat">
                            <thead class="bg-gradient-to-r from-teal-500 to-teal-700 text-white">
                                <tr>
                                    <th class="p-3 font-medium text-center">Tanggal</th>
                                    <th class="p-3 font-medium text-center">Invoice</th>
                                    <th class="p-3 font-medium">Pelanggan</th>
                                    <th class="p-3 font-medium text-right">Total</th>
                                    <th class="p-3 font-medium text-right">Diskon</th>
                                    <th class="p-3 font-medium text-right">Bayar</th>
                                    <th class="p-3 font-medium text-right">Kembali</th>
                                    <th class="p-3 font-medium text-center">Metode</th>
                                    <th class="p-3 font-medium">Kasir</th>
                                    <th class="p-3 font-medium text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="riwayat-body" class="divide-y divide-gray-100"></tbody>
                        </table>
                    </div>
                    <div class="flex justify-between items-center p-4 border-t border-gray-100">
                        <button id="prev-page" class="px-4 py-2 bg-teal-100 text-teal-700 rounded-lg hover:bg-teal-200 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Sebelumnya
                        </button>
                        <span id="page-info" class="text-sm text-gray-600"></span>
                        <button id="next-page" class="px-4 py-2 bg-teal-100 text-teal-700 rounded-lg hover:bg-teal-200 transition-colors flex items-center">
                            Selanjutnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Modal Detail -->
            <<div id="modal-detail" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 p-4">
                <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl max-h-[90vh] overflow-hidden border border-teal-100">
                    <!-- Header dengan gradient teal -->
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Detail Transaksi
                            </h3>
                            <button id="close-detail" class="text-teal-100 hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Body Content -->
                    <div class="p-5 overflow-y-auto max-h-[60vh]">
                        <div id="detail-body" class="space-y-4"></div>
                    </div>

                    <!-- Footer dengan aksen teal -->
                    <div class="flex justify-end p-5 border-t border-teal-100 bg-teal-50">
                        <button id="btn-print" class="px-5 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-lg hover:from-teal-600 hover:to-teal-700 transition-all flex items-center shadow-md hover:shadow-teal-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2z" />
                            </svg>
                            Cetak Invoice
                        </button>
                    </div>
                </div>
        </div>
    </div>
    </div>
    <x-script-admin />
</x-header_kasir>