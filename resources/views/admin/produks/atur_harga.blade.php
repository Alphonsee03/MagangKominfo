<x-header-admin>
    <x-navbar />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content p-6">
            <h1 class="text-2xl font-bold mb-4">Atur Harga Produk</h1>

            <form action="{{ route('admin.produks.atur_harga.update') }}" method="POST">
                @csrf
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama</th>
                                <th class="px-4 py-2 text-left">Kategori</th>
                                <th class="px-4 py-2 text-left">Harga Beli</th>
                                <th class="px-4 py-2 text-left">Harga Jual</th>
                                <th class="px-4 py-2 text-left">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produks as $produk)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $produk->nama }}</td>
                                <td class="px-4 py-2">{{ $produk->kategori->nama ?? '-' }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($produk->harga_beli,0,',','.') }}</td>
                                <td class="px-4 py-2">
                                    <input type="number" name="harga_jual[{{ $produk->id }}]" 
                                           value="{{ $produk->harga_jual }}" 
                                           class="border px-3 py-1 rounded w-32">
                                </td>
                                <td class="px-4 py-2">{{ $produk->stok }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
                    <a href="{{ route('admin.produks.index') }}" class="ml-2 text-gray-600">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <x-script-admin />
</x-header-admin>
