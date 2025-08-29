<x-header-admin>
    <x-navbar />
    <x-topheader />
    <div class="pc-container">
        <div class="pc-content">
            <h2 class="font-bold text-2xl mb-4">Pembelian Stok</h2>

            <a href="{{ route('admin.pembelians.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Pembelian</a>

            <table class="w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Tanggal</th>
                        <th class="border px-4 py-2">Supplier</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembelians as $pembelian)
                    <tr>
                        <td class="border px-4 py-2">
                            <p><strong>Tanggal:</strong> {{ $pembelian->tanggal ? $pembelian->tanggal->format('d-m-Y H:i:s') : '-' }}</p>

                        </td>
                        <td class="border px-4 py-2">{{ $pembelian->supplier->nama }}</td>
                        <td class="border px-4 py-2">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.pembelians.show', $pembelian->id) }}"
                                class="text-blue-600">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $pembelians->links() }}
            </div>
        </div>
    </div>
    <x-script-admin />
</x-header-admin>