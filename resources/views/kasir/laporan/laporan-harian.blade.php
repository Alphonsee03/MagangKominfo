<x-header_kasir title="Laporan Harian">
    @vite('resources/js/laporan-harian.js')
    <x-navbar_kasir />
    <x-topheader />
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        
        }

        .card-container {
            position: relative;
        }

        .card-back {
            position: absolute;
            top: 6px;
            left: 6px;
            right: -6px;
            bottom: -6px;
            border-radius: 12px;
            z-index: 0;
            transition: all 0.3s ease;
        }

        .card-front {
            position: relative;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .card-container:hover .card-front {
            transform: translate(-2px, -2px);
        }

        .card-container:hover .card-back {
            transform: translate(2px, 2px);
        }

        .header-text {
            color: #1e293b;
        }

        .dash-card-layer-container {
            position: relative;
            height: 100%;
        }

        /* Lapisan belakang card */
        .dash-card-layer-back {
            position: absolute;
            top: 6px;
            left: 6px;
            right: -6px;
            bottom: -6px;
            border-radius: 12px;
            z-index: 0;
            transition: all 0.3s ease;
            opacity: 0.7;
        }

        /* Lapisan depan card */
        .dash-card-layer-front {
            position: relative;
            z-index: 10;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        /* Efek hover */
        .dash-card-layer-container:hover .dash-card-layer-front {
            transform: translate(-2px, -2px);
            box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .dash-card-layer-container:hover .dash-card-layer-back {
            transform: translate(2px, 2px);
            opacity: 0.8;
        }

        /* Warna lapisan belakang untuk setiap card */
        .dash-layer-method {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
        }

        .dash-layer-popular {
            background: linear-gradient(135deg, #fb7185 0%, #e11d48 100%);
        }

        .dash-layer-recent {
            background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
        }

        /* Styling untuk tabel */
        .dash-table {
            width: 100%;
        }

        .dash-popular-content {
            color: #e11d48;
        }

        .dash-recent-content {
            color: #8b5cf6;
        }
    </style>
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
                    <!-- Card Transaksi -->
                    <div class="card-container">
                        <div class="card-back bg-teal-200"></div>
                        <div class="card-front bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-teal-50 rounded-xl">
                                    <i class="fas fa-receipt text-teal-600 text-lg"></i>
                                </div>
                            </div>
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Transaksi</h4>
                            <p id="rekap-transaksi" class="text-2xl font-bold text-gray-800">0</p>
                            <div class="mt-3 pt-3 border-t border-gray-100 flex items-center">
                                <span class="text-xs text-gray-400"><i class="fas fa-clock mr-1"></i> Hari ini</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Omset Harian -->
                    <div class="card-container">
                        <div class="card-back bg-green-200"></div>
                        <div class="card-front bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-green-50 rounded-xl">
                                    <i class="fas fa-chart-line text-green-600 text-lg"></i>
                                </div>
                            </div>
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Omset Harian</h4>
                            <p id="rekap-omzet" class="text-2xl font-bold text-gray-800">Rp 0</p>
                            <div class="mt-3 pt-3 border-t border-gray-100 flex items-center">
                                <span class="text-xs text-gray-400"><i class="fas fa-clock mr-1"></i> Hari ini</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Total Bayar -->
                    <div class="card-container">
                        <div class="card-back bg-blue-200"></div>
                        <div class="card-front bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-blue-50 rounded-xl">
                                    <i class="fas fa-credit-card text-blue-600 text-lg"></i>
                                </div>
                            </div>
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Pembayaran</h4>
                            <p id="rekap-bayar" class="text-2xl font-bold text-gray-800">Rp 0</p>
                            <div class="mt-3 pt-3 border-t border-gray-100 flex items-center">
                                <span class="text-xs text-gray-400"><i class="fas fa-clock mr-1"></i> Hari ini</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Total Kembali -->
                    <div class="card-container">
                        <div class="card-back bg-amber-200"></div>
                        <div class="card-front bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-amber-50 rounded-xl">
                                    <i class="fas fa-money-bill-wave text-amber-600 text-lg"></i>
                                </div>
                            </div>
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Kembalian</h4>
                            <p id="rekap-kembali" class="text-2xl font-bold text-gray-800">Rp 0</p>
                            <div class="mt-3 pt-3 border-t border-gray-100 flex items-center">
                                <span class="text-xs text-gray-400"><i class="fas fa-clock mr-1"></i> Hari ini</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Total Item Terjual -->
                    <div class="card-container">
                        <div class="card-back bg-purple-200"></div>
                        <div class="card-front bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-purple-50 rounded-xl">
                                    <i class="fas fa-shopping-cart text-purple-600 text-lg"></i>
                                </div>
                            </div>
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Item Terjual</h4>
                            <p id="rekap-item" class="text-2xl font-bold text-gray-800">0 pcs</p>
                            <div class="mt-3 pt-3 border-t border-gray-100 flex items-center">
                                <span class="text-xs text-gray-400"><i class="fas fa-clock mr-1"></i> Sejak tengah malam</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                    <!-- Card Metode Bayar -->
                    <div class="dash-card-layer-container">
                        <div class="dash-card-layer-back dash-layer-method"></div>
                        <div class="dash-card-layer-front p-6">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-extrabold text-slate-900">Metode Bayar</span>
                                <span class="text-[10px] text-gray-400">Today</span>
                            </div>
                            <div class="dash-chart-container">
                                <canvas id="rekap-metode" width="100" height="100"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Terlaris -->
                    <div class="col-span-2 dash-card-layer-container">
                        <div class="dash-card-layer-back dash-layer-popular"></div>
                        <div class="dash-card-layer-front p-5">
                            <div class="text-center mb-4">
                                <h4 class="text-md font-semibold mb-1 flex items-center justify-center dash-popular-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    PRODUK TERLARIS
                                </h4>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="dash-table text-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-left pb-2 text-slate-900">Produk :</th>
                                            <th class="text-center pb-2 text-slate-900">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody id="produk-terlaris-table">
                                        <tr>
                                            <td colspan="2" class="text-center py-3 text-gray-800">Loading data...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Waktu Transaksi Terakhir -->
                    <div class="dash-card-layer-container">
                        <div class="dash-card-layer-back dash-layer-recent"></div>
                        <div class="dash-card-layer-front p-5">
                            <div class="text-center mb-4">
                                <h4 class="text-sm font-semibold text-lg mb-1 flex items-center justify-center dash-recent-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    5 TRANSAKSI TERAKHIR
                                </h4>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="dash-table text-xs">
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="waktu-transaksi-table">
                                        <tr>
                                            <td colspan="2" class="text-center py-3 text-gray-400">Loading data...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-script-admin />
</x-header_kasir>