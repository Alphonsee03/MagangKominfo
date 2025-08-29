<div class="pc-content">
    <table class="w-full border-collapse  text-left bg-white">
        <thead class="font-bold rounded-md bg-gradient-to-br from-teal-500 to-sky-400  text-white">
            <tr >
                <th class="px-4 py-3 ">No.</th>
                <th class="px-4 py-3 text-center">Code</th>
                <th class="px-4 py-3 text-center">Nama</th>
                <th class="px-4 py-3">Kategori</th>
                <th class="px-4 py-3">Harga Beli</th>
                <th class="px-4 py-3">Harga Jual</th>
                <th class="px-4 py-3">Stok</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="produkTableBody" class="divide-y divide-gray-200">
            @forelse($produks as $i => $produk)
            <tr class="hover:bg-gray-50 transition " data-id="{{ $produk->id }}">
                <td class="px-4 py-2 font-medium text-gray-600">{{ $i + $produks->firstItem() }}</td>
                <td class="px-4 py-2 font-bold text-center">{{ $produk->kode_produk }}</td>
                <td class="px-4 py-2 font-semibold text-gray-800 text-center">{{ $produk->nama }}</td>
                <td class="px-4 py-2">{{ $produk->kategori->nama ?? '-' }}</td>
                <td class="px-4 py-2 text-gray-700">Rp {{ number_format($produk->harga_beli,0,',','.') }}</td>
                <td class="px-4 py-2 text-gray-700">Rp {{ number_format($produk->harga_jual,0,',','.') }}</td>
                <td class="px-4 py-2">
                    <span id="stok-{{ $produk->id }}" class="px-2 py-1 rounded bg-teal-100 text-teal-700 text-sm">
                        {{ $produk->stok }}
                    </span>
                </td>
                <td class="px-4 py-2 flex items-center justify-center space-x-2">
                    <button type="button" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm shadow-sm btn-edit transition"
                        data-produk='@json($produk)'>✏️</button>

                    <form action="{{ route('admin.produks.destroy',$produk->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus?')"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm shadow-sm transition">
                            🗑️
                        </button>
                    </form>

                    <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm shadow-sm btn-stok transition"
                        data-id="{{ $produk->id }}">➕</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-4">Tidak ada produk ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4 px-2">
        {{ $produks->links() }}
    </div>

</div>