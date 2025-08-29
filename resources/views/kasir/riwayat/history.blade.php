<x-header_kasir>
    @vite('resources/js/kasir-history.js')
    <x-navbar_kasir />
    <x-topheader/>
    
    <div class="pc-container">
        <div class="pc-content">

            <div class="p-4 space-y-6">

                <!-- Tabel Riwayat -->
                <div class="bg-white shadow rounded-xl p-4">
                    <h2 class="text-lg font-semibold mb-4">Riwayat Penjualan</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border" id="table-riwayat">
                            <thead class="bg-gray-100 text-gray-600">
                                <tr>
                                    <th class="p-2">Tanggal</th>
                                    <th class="p-2">Invoice</th>
                                    <th class="p-2">Pelanggan</th>
                                    <th class="p-2">Total</th>
                                    <th class="p-2">Diskon</th>
                                    <th class="p-2">Bayar</th>
                                    <th class="p-2">Kembali</th>
                                    <th class="p-2">Metode</th>
                                    <th class="p-2">Kasir</th>
                                    <th class="p-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="riwayat-body"></tbody>
                        </table>
                    </div>
                    <div class="flex justify-between items-center mt-3">
                        <button id="prev-page" class="px-3 py-1 bg-gray-200 rounded">Prev</button>
                        <span id="page-info" class="text-sm"></span>
                        <button id="next-page" class="px-3 py-1 bg-gray-200 rounded">Next</button>
                    </div>
                </div>

            </div>

            <!-- Modal Detail -->
            <div id="modal-detail" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
                <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 relative">
                    <button id="close-detail" class="absolute top-2 right-2 text-gray-500">&times;</button>
                    <h3 class="text-lg font-bold mb-4">Detail Transaksi</h3>
                    <div id="detail-body" class="space-y-2"></div>
                    <div class="mt-4 flex justify-end">
                        <button id="btn-print" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Cetak Invoice</button>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <x-script-admin/>
</x-header_kasir>