<x-header_kasir>
    @vite('resources/js/laporan-harian.js')
    <x-navbar_kasir />
    <x-topheader />
    <div class="pc-container">
        <div class="pc-content">
            <div class="p-6 space-y-6 ">

                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Laporan Harian
                </h2>

                <!-- Section 1: Ringkasan Angka -->
                <div id="rekap" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="mx-auto">
                                <h4 class="text-lg font-medium text-gray-500 uppercase tracking-wide">Transaksi</h4>
                                <p id="rekap-transaksi" class="text-md text-center font-extrabold text-teal-600 mt-1">0</p>
                            </div>
                            <div class="p-2 bg-teal-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="mx-auto">
                                <h4 class="text-lg font-medium text-gray-500 uppercase tracking-wide">Omset Harian</h4>
                                <p id="rekap-omzet" class="text-md font-bold text-center text-green-600 mt-1">Rp 0</p>
                            </div>
                            <div class="p-2 bg-green-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-md  font-medium text-gray-500 uppercase tracking-wide">Total Bayar</h4>
                                <p id="rekap-bayar" class="text-xl text-center font-bold text-blue-600 mt-1">Rp 0</p>
                            </div>
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Kembali</h4>
                                <p id="rekap-kembali" class="text-xl font-bold text-amber-600 mt-1">Rp 0</p>
                            </div>
                            <div class="p-2 bg-amber-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <!-- Total Item Terjual -->
                    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm hover:shadow-sm transition-shadow">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-medium text-gray-700">Total Item Terjual</h4>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <p id="rekap-item" class="text-2xl font-bold text-purple-600">0 pcs</p>
                        <p class="text-xs text-gray-500 mt-1">Sejak tengah malam</p>
                    </div>
                </div>

                <div class=" grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white shadow rounded-xl p-6 max-w-[270px]">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-extrabold text-slate-900">Metode Bayar</span>
                            <span class="text-[10px] text-gray-400">Today</span>
                        </div>
                        <div class="flex justify-center">
                            <canvas id="rekap-metode" width="100" height="100"></canvas>
                        </div>
                    </div>

                    <!-- Section 3: Info Tambahan -->
                    <!-- Produk Terlaris -->
                    <div class="bg-gradient-to-br from-rose-400 to-rose-700 rounded-xl p-5 shadow-lg text-white">
                        <div class="text-center mb-4">
                            <h4 class="text-md text-white font-semibold mb-1 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                PRODUK TERLARIS
                            </h4>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-rose-400/30">
                                        <th class="text-left pb-2 font-semibold">Produk</th>
                                        <th class="text-right pb-2 font-semibold">Qty</th>
                                    </tr>
                                </thead>

                                <tbody id="produk-terlaris-table">
                                    <!-- Data akan diisi oleh JavaScript -->
                                    <tr>
                                        <td colspan="2" class="text-center py-3 text-rose-200/80">Loading data...</td>
                                    </tr>
                                </tbody>


                            </table>
                        </div>
                    </div>

                    <!-- Waktu Transaksi Terakhir -->
                    <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl p-5 shadow-lg text-white">
                        <div class="text-center mb-4">
                            <h4 class="text-sm text-white font-semibold mb-1 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                5 TRANSAKSI TERAKHIR
                            </h4>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="border-b border-violet-600/30">
                                        <th class="text-center pb-2 font-semibold">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody id="waktu-transaksi-table">
                                    <!-- Data akan diisi oleh JavaScript -->
                                    <tr>
                                        <td colspan="2" class="text-center py-3 text-violet-200/80">Loading data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    
                </div>





            </div>
        </div>
    </div>
    <x-script-admin />
</x-header_kasir>