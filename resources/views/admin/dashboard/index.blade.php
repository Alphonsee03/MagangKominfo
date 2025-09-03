<x-header-admin>

    <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
        <div class="loader-track h-[5px] w-full inline-block absolute overflow-hidden top-0">
            <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
        </div>
    </div>
    <x-navbar />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">
            <div class="p-6 space-y-8">

                <!-- Header -->
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-700">Dashboard Admin</h2>
                    <div>
                        <select id="filter-range" class="border rounded-lg px-3 py-2">
                            <option value="today">Hari Ini</option>
                            <option value="week">Minggu Ini</option>
                            <option value="month">Bulan Ini</option>
                            <option value="year">Tahun Ini</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                </div>

                <!-- Card Summary -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500">Omzet</h4>
                        <p id="card-omzet" class="text-2xl font-bold text-green-600">Rp 0</p>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500">Jumlah Transaksi</h4>
                        <p id="card-transaksi" class="text-2xl font-bold text-blue-600">0</p>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500">Total Item Terjual</h4>
                        <p id="card-item" class="text-2xl font-bold text-indigo-600">0 pcs</p>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500">Pelanggan Baru</h4>
                        <p id="card-pelanggan" class="text-2xl font-bold text-yellow-500">0</p>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500">Produk Stok Menipis</h4>
                        <p id="card-lowstock" class="text-2xl font-bold text-red-500">0</p>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="font-semibold mb-3">Omzet Harian (30 Hari)</h4>
                        <canvas id="chart-omzet-harian" class="w-full h-64"></canvas>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="font-semibold mb-3">Omzet Bulanan (Tahun Ini)</h4>
                        <canvas id="chart-omzet-bulanan" class="w-full h-64"></canvas>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="font-semibold mb-3">Metode Pembayaran</h4>
                        <canvas id="chart-metode" class="w-full h-64"></canvas>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="font-semibold mb-3">Top 10 Produk Terlaris</h4>
                        <canvas id="chart-terlaris" class="w-full h-64"></canvas>
                    </div>
                </div>

                <!-- Analitik Pelanggan & Supplier -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="font-semibold mb-3">Pelanggan Baru Per Bulan</h4>
                        <canvas id="chart-pelanggan" class="w-full h-64"></canvas>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="font-semibold mb-3">Kontribusi Omzet Supplier</h4>
                        <canvas id="chart-supplier" class="w-full h-64"></canvas>
                    </div>
                </div>

                <!-- Tabel Ringkasan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="font-semibold mb-3">Transaksi Terakhir</h4>
                        <table class="w-full text-sm border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2">Tanggal</th>
                                    <th class="p-2">Invoice</th>
                                    <th class="p-2">Pelanggan</th>
                                    <th class="p-2">Total</th>
                                </tr>
                            </thead>
                            <tbody id="table-transaksi"></tbody>
                        </table>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="font-semibold mb-3">Produk Stok Menipis</h4>
                        <table class="w-full text-sm border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2">Kode</th>
                                    <th class="p-2">Nama</th>
                                    <th class="p-2">Stok</th>
                                    <th class="p-2">Supplier</th>
                                </tr>
                            </thead>
                            <tbody id="table-lowstock"></tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <x-footer-admin />

    <x-script-admin />
</x-header-admin>