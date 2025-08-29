<x-header-admin>
    <x-navbar />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">
            <h2 class="text-2xl font-bold mb-4 text-indigo-600">Detail Pembelian</h2>

            <div class="mb-4">
                <p><strong>Supplier:</strong> {{ $pembelian->supplier->nama }}</p>
                <p><strong>Tanggal:</strong> {{ $pembelian->tanggal ? $pembelian->tanggal->format('d-m-Y H:i:s') : '-' }}</p>

                <p><strong>Total:</strong> Rp {{ number_format($pembelian->total, 0, ',', '.') }}</p>
            </div>

            <table class="min-w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2">Produk</th>
                        <th class="border px-3 py-2">Jumlah</th>
                        <th class="border px-3 py-2">Harga Beli</th>
                        <th class="border px-3 py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembelian->detailPembelians as $detail)
                        <tr>
                            <td class="border px-3 py-2">{{ $detail->produk->nama }}</td>
                            <td class="border px-3 py-2">{{ $detail->jumlah }}</td>
                            <td class="border px-3 py-2">Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                            <td class="border px-3 py-2">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <a href="{{ route('admin.pembelians.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
            </div>
        </div>
    </div>

    <x-script-admin />
</x-header-admin>
