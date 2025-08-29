<x-header_kasir>
    @vite('resources/js/laporan-harian.js')
    <x-navbar_kasir />
    <x-topheader />
    <div class="pc-container">
        <div class="pc-content">
            <div class="p-4 space-y-6">

                <h2 class="text-xl font-bold text-gray-700">Laporan Harian</h2>

                <!-- Rekap Harian -->
                <div id="rekap" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500">Jumlah Transaksi</h4>
                        <p id="rekap-transaksi" class="text-xl font-bold">0</p>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500">Omzet</h4>
                        <p id="rekap-omzet" class="text-xl font-bold">Rp 0</p>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500">Total Bayar</h4>
                        <p id="rekap-bayar" class="text-xl font-bold">Rp 0</p>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500">Total Kembali</h4>
                        <p id="rekap-kembali" class="text-xl font-bold">Rp 0</p>
                    </div>
                    <div class="bg-white shadow rounded-xl p-4">
                        <h4 class="text-sm text-gray-500 mb-2">Metode Pembayaran</h4>
                        <canvas id="rekap-metode" class="w-full h-32"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-script-admin />
</x-header_kasir>