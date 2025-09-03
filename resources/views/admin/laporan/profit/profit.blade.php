<x-header-admin>
    <x-navbar />
    <x-topheader />
    <div class="pc-container">
        <div class="pc-content">
            <div class="p-4 space-y-6">
                <h2 class="text-xl font-bold text-gray-700">Laporan Profit</h2>
                <div class="text-right mb-4">
                    <button id="btn-export" class="bg-red-500 text-white px-4 py-2 rounded">
                        Export PDF
                    </button>
                </div>


                <div class="bg-white p-4 shadow rounded-xl space-y-3 md:space-y-0 md:flex md:items-center md:gap-4">
                    <input type="date" id="start_date" class="border rounded px-2 py-1">
                    <input type="date" id="end_date" class="border rounded px-2 py-1">
                </div>

                <!-- Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500">Total Penjualan</h4>
                        <p id="total-penjualan" class="text-xl font-bold">Rp 0</p>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500">Total Modal</h4>
                        <p id="total-modal" class="text-xl font-bold">Rp 0</p>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500">Profit Bersih</h4>
                        <p id="total-profit" class="text-xl font-bold text-green-600">Rp 0</p>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white shadow rounded-xl p-4 mt-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2">Invoice</th>
                                <th class="p-2">Tanggal</th>
                                <th class="p-2">Kasir</th>
                                <th class="p-2">Produk</th>
                                <th class="p-2">Qty</th>
                                <th class="p-2">Harga Beli</th>
                                <th class="p-2">Harga Jual</th>
                                <th class="p-2">Subtotal</th>
                                <th class="p-2">Profit</th>
                            </tr>
                        </thead>
                        <tbody id="table-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/admin-laporan-profit.js') }}"></script>
    <x-script-admin />
</x-header-admin>