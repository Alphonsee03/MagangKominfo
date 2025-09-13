<x-header-admin>
    @vite(['resources/js/admin-dashboard.js', 'resources/css/admin-dashboard.css'])
    <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
        <div class="loader-track h-[5px] w-full inline-block absolute overflow-hidden top-0">
            <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
        </div>
    </div>
    <x-navbar />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">
            <div class="p-6 space-y-8 -mt-10">
                <!-- Filter -->
                <div class="flex flex-wrap items-center gap-4 mb-8">
                    <div>
                        <label for="periode" class="block text-xs font-semibold text-slate-600 mb-1">Periode</label>
                        <div class="relative">
                            <select id="periode" class="peer border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 rounded-lg px-4 py-2 pr-10 text-sm bg-white dark:bg-themedark-cardbg transition">
                                <option value="minggu">Minggu ini</option>
                                <option value="bulan">Bulan ini</option>
                                <option value="tahun">Tahun</option>
                                <option value="all">Semua</option>
                            </select>
                            
                        </div>
                    </div>
                    <div id="tahun-container" class="transition-all duration-200">
                        <label for="tahun" class="block text-xs font-semibold text-slate-600 mb-1">Tahun</label>
                        <div class="relative">
                            <select id="tahun" class="peer border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 rounded-lg px-4 py-2 pr-10 text-sm bg-white dark:bg-themedark-cardbg transition hidden">
                                <!-- Tahun options will be populated dynamically -->
                            </select>
                        
                        </div>
                    </div>
                </div>


                <div id="loading" class="hidden flex items-center justify-center py-10">
                    <svg class="animate-spin h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4l3.5-3.5L12 0v4a8 8 0 100 16v-4l-3.5 3.5L12 24v-4a8 8 0 01-8-8z">
                        </path>
                    </svg>
                    <span class="ml-2 text-gray-600">Loading...</span>
                </div>


                <!-- Row 1: Cards -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <!-- Total Omzet Card -->
                    <div class="admin-card-container">
                        <div class="admin-card-back admin-layer-omzet"></div>
                        <div class="admin-card-front">
                            <div class="admin-card-decor admin-decor-omzet">
                                <div class="progress-circle" style="--percentage: 70">
                                    <span class="progress-text">70%</span>
                                </div>
                            </div>
                            <p class="text-slate-900 font-semibold  ">Total Omset</p>
                            <h2 id="totalOmzet" class="admin-card-value">Rp 0</h2>
                        </div>
                    </div>

                    <!-- Total Profit Card -->
                    <div class="admin-card-container">
                        <div class="admin-card-back admin-layer-profit"></div>
                        <div class="admin-card-front">
                            <div class="admin-card-decor admin-decor-profit">
                                <div class="progress-circle" style="--percentage: 85">
                                    <span class="progress-text">85%</span>
                                </div>
                            </div>
                            <p class="text-slate-900 font-semibold  ">Total Profit</p>
                            <h2 id="totalProfit" class="admin-card-value">Rp 0</h2>
                        </div>
                    </div>

                    <!-- Total Transaksi Card -->
                    <div class="admin-card-container">
                        <div class="admin-card-back admin-layer-transaksi"></div>
                        <div class="admin-card-front">
                            <div class="admin-card-decor admin-decor-transaksi">
                                <div class="progress-circle" style="--percentage: 60">
                                    <span class="progress-text">60%</span>
                                </div>
                            </div>
                            <p class="text-slate-900 font-semibold  ">Total Transaksi</p>
                            <h2 id="totalTransaksi" class="admin-card-value">0</h2>
                        </div>
                    </div>

                    <!-- Total Produk Terjual Card -->
                    <div class="admin-card-container">
                        <div class="admin-card-back admin-layer-produk"></div>
                        <div class="admin-card-front">
                            <div class="admin-card-decor admin-decor-produk">
                                <div class="progress-circle" style="--percentage: 45">
                                    <span class="progress-text">45%</span>
                                </div>
                            </div>
                            <p class="text-slate-900 font-semibold  ">Total Produk Terjual</p>
                            <h2 id="totalProduk" class="admin-card-value">0</h2>
                        </div>
                    </div>

                    <!-- Total Pembelian Barang Card -->
                    <div class="admin-card-container">
                        <div class="admin-card-back admin-layer-pembelian"></div>
                        <div class="admin-card-front">
                            <div class="admin-card-decor admin-decor-pembelian">
                                <div class="progress-circle" style="--percentage: 30">
                                    <span class="progress-text">30%</span>
                                </div>
                            </div>
                            <p class="text-slate-900 font-semibold -mt-3 ">Total Pembelian Barang</p> 
                            <h2 id="totalPembelian" class="admin-card-value mt-2">Rp 0</h2>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Chart Omzet & Profit -->
                <div class="bg-white shadow rounded-xl border-2px border-teal700 p-4">
                    <h4 class="font-semibold mb-3">Omzet & Profit</h4>
                    <div id="chart-container" class="w-full max-w-5xl mx-auto">
                        <canvas id="chart-bar"></canvas>
                    </div>
                </div>

                <!-- Row 3: Produk Terlaris & Supplier -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Top 5 Produk Terlaris -->
                    <div class="stats-card-container">
                        <div class="stats-card-back stats-layer-produk"></div>
                        <div class="stats-card-front">
                            <div class="h-3 -mx-4 -mt-4 mb-4 rounded-t-lg bg-purple-500"></div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-semibold text-slate-800 flex items-center">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-fire text-purple-600"></i>
                                    </div>
                                    Top 5 Produk Terlaris
                                </h4>
                                <span class="text-xs bg-purple-100 text-purple-800 py-1 px-2 rounded-full">Hari Ini</span>
                            </div>
                            <ul id="produk-terlaris" class="space-y-3"></ul>
                        </div>
                    </div>

                    <!-- Top 5 Supplier -->
                    <div class="stats-card-container">
                        <div class="stats-card-back stats-layer-supplier"></div>
                        <div class="stats-card-front">
                            <div class="h-3 -mx-4 -mt-4 mb-4 rounded-t-lg bg-blue-600"></div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-semibold text-slate-800 flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-truck text-blue-600"></i>
                                    </div>
                                    Top 5 Supplier
                                </h4>
                                <span class="text-xs bg-blue-100 text-blue-800 py-1 px-2 rounded-full">Bulan Ini</span>
                            </div>
                            <ul id="supplier-terbanyak" class="space-y-3"></ul>
                        </div>
                    </div>
                </div>

                <!-- Row 4: Tabel -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- 10 Transaksi Tertinggi -->
                    <div class="stats-card-container">
                        <div class="stats-card-back stats-layer-transaksi"></div>
                        <div class="stats-card-front">
                            <div class="h-3 -mx-4 -mt-4 mb-4 rounded-t-lg bg-green-600"></div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-semibold text-slate-800 flex items-center">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-receipt text-green-600"></i>
                                    </div>
                                    10 Transaksi Tertinggi
                                </h4>
                                <span class="text-xs bg-green-100 text-green-800 py-1 px-2 rounded-full">Total</span>
                            </div>
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left pb-2 text-slate-600 font-semibold">Invoice</th>
                                        <th class="text-right pb-2 text-slate-600 font-semibold">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="transaksi-tertinggi" class="divide-y"></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Produk Stok Kritis -->
                    <div class="stats-card-container">
                        <div class="stats-card-back stats-layer-stok"></div>
                        <div class="stats-card-front">
                            <div class="h-3 -mx-4 -mt-4 mb-4 rounded-t-lg bg-amber-500"></div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-semibold text-slate-800 flex items-center">
                                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-exclamation-triangle text-amber-600"></i>
                                    </div>
                                    Produk Stok Kritis
                                </h4>
                                <span class="text-xs bg-amber-100 text-amber-800 py-1 px-2 rounded-full">Perhatian</span>
                            </div>
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left pb-2 text-slate-600 font-semibold">Produk</th>
                                        <th class="text-right pb-2 text-slate-600 font-semibold">Stok</th>
                                    </tr>
                                </thead>
                                <tbody id="stok-kritis" class="divide-y"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <x-script-admin />
</x-header-admin>