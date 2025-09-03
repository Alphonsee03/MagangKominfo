<x-header-admin>
    <x-navbar />
    <x-topheader />
    <div class="pc-container">
        <div class="pc-content">

            <div class="p-6 space-y-6">
                <h2 class="text-xl font-bold">Laporan Pembelian</h2>

                <!-- Filter -->
                <div class="bg-white p-4 shadow rounded-xl flex gap-3 items-center">
                    <input type="date" id="start_date" class="border rounded px-2 py-1">
                    <input type="date" id="end_date" class="border rounded px-2 py-1">

                    <select id="supplier_id" class="border rounded px-2 py-1">
                        <option value="">-- Semua Supplier --</option>
                        @foreach($suppliers as $s)
                        <option value="{{ $s->id }}">{{ $s->nama }}</option>
                        @endforeach
                    </select>

                    <button id="btn-export" class="bg-red-500 text-white px-4 py-2 rounded">
                        Export PDF
                    </button>
                </div>

                <!-- Tabel -->
                <div class="bg-white shadow rounded-xl overflow-x-auto">
                    <table class="w-full border text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 border">No.</th>
                                <th class="p-2 border">Tanggal</th>
                                <th class="p-2 border">Produk</th>
                                <th class="p-2 border">Kode</th>
                                <th class="p-2 border">Supplier</th>
                                <th class="p-2 border">Jumlah</th>
                                <th class="p-2 border">Harga Beli</th>
                                <th class="p-2 border">Subtotal</th>
                                <th class="p-2 border">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="table-body"></tbody>
                    </table>
                </div>
            </div>



        </div>
    </div>
    <script src="{{ asset('assets/js/admin-laporan-pembelian.js') }}"></script>
    <x-script-admin />
</x-header-admin>