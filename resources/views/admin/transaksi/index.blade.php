<x-header-admin>

    <x-navbar />
    <x-topheader />
    <div class="pc-container">
        <div class="pc-content">
            <div class="text-right">
                <button id="btn-export" class="bg-red-500 text-white px-4 py-2 rounded">
                    Export PDF
                </button>


            </div>

            <div class="p-6 space-y-6 -mt-10">
                <h2 class="text-xl font-bold text-gray-700">Daftar Transaksi</h2>

                <!-- Filter -->
                <div class="bg-white p-4 shadow rounded-xl space-y-3 md:space-y-0 md:flex md:items-center md:gap-4">
                    <input type="date" id="start_date" class="border rounded px-2 py-1">
                    <input type="date" id="end_date" class="border rounded px-2 py-1">
                    <select id="metode" class="border rounded px-2 py-1">
                        <option value="">-- Semua Metode --</option>
                        <option value="cash">Cash</option>
                        <option value="qris">QRIS</option>
                    </select>
                    <input type="text" id="search" placeholder="Cari invoice / pelanggan / kasir" class="border rounded px-2 py-1 w-64">

                </div>

                <!-- Table -->
                <div class="bg-white shadow rounded-xl overflow-x-auto">
                    <table class="w-full text-sm border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2">Tanggal</th>
                                <th class="p-2">Invoice</th>
                                <th class="p-2">Kasir</th>
                                <th class="p-2">Pelanggan</th>
                                <th class="p-2">Total</th>
                                <th class="p-2">Bayar</th>
                                <th class="p-2">Metode</th>
                                <th class="p-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-body"></tbody>
                    </table>
                </div>

                <!-- Modal Detail -->
                <div id="modal-detail" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center">
                    <div class="bg-white p-6 rounded-xl w-3/4 md:w-1/2 max-h-[80vh] overflow-y-auto">
                        <h3 class="text-lg font-semibold mb-3">Detail Transaksi</h3>
                        <div id="detail-body" class="text-sm space-y-2"></div>
                        <div class="flex justify-end gap-2 mt-4">
                            <button id="btn-print" class="bg-green-500 text-white px-4 py-2 rounded">
                                Export Detail PDF
                            </button>
                            <button id="close-detail" class="bg-gray-500 text-white px-4 py-2 rounded">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>


            </div>
            <div class="flex justify-between items-center mt-4">
                <button id="prev-page" class="px-3 py-1 bg-gray-200 rounded">Prev</button>
                <span id="page-info" class="text-sm text-gray-600">Halaman 1 dari 1</span>
                <button id="next-page" class="px-3 py-1 bg-gray-200 rounded">Next</button>
            </div>



        </div>
    </div>
    <script src="{{ asset('assets/js/admin-transaksi.js') }}"></script>
    <x-script-admin />


</x-header-admin>