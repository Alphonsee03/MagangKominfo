<div class="pc-content">
    <table class="w-full border-collapse  text-left bg-white">
        <thead class="font-bold rounded-md bg-gradient-to-br from-teal-500 to-sky-400  text-white">
            <tr >
                <th class="px-4 py-3">
                    <a href="{{ route('admin.produks.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => $sortBy == 'id' && $sortOrder == 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-teal-200">
                        No. @if($sortBy == 'id')<i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }} ml-1"></i>@else<i class="fas fa-sort ml-1 text-teal-200"></i>@endif
                    </a>
                </th>
                <th class="px-4 py-3 text-center">Code</th>
                <th class="px-4 py-3 text-center">
                    <a href="{{ route('admin.produks.index', array_merge(request()->query(), ['sort_by' => 'nama', 'sort_order' => $sortBy == 'nama' && $sortOrder == 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-teal-200">
                        Nama @if($sortBy == 'nama')<i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }} ml-1"></i>@else<i class="fas fa-sort ml-1 text-teal-200"></i>@endif
                    </a>
                </th>
                <th class="px-4 py-3">Kategori</th>
                <th class="px-4 py-3">
                    <a href="{{ route('admin.produks.index', array_merge(request()->query(), ['sort_by' => 'harga_beli', 'sort_order' => $sortBy == 'harga_beli' && $sortOrder == 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-teal-200">
                        Harga Beli @if($sortBy == 'harga_beli')<i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }} ml-1"></i>@else<i class="fas fa-sort ml-1 text-teal-200"></i>@endif
                    </a>
                </th>
                <th class="px-4 py-3">
                    <a href="{{ route('admin.produks.index', array_merge(request()->query(), ['sort_by' => 'harga_jual', 'sort_order' => $sortBy == 'harga_jual' && $sortOrder == 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-teal-200">
                        Harga Jual @if($sortBy == 'harga_jual')<i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }} ml-1"></i>@else<i class="fas fa-sort ml-1 text-teal-200"></i>@endif
                    </a>
                </th>
                <th class="px-4 py-3">
                    <a href="{{ route('admin.produks.index', array_merge(request()->query(), ['sort_by' => 'stok', 'sort_order' => $sortBy == 'stok' && $sortOrder == 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-teal-200">
                        Stok @if($sortBy == 'stok')<i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }} ml-1"></i>@else<i class="fas fa-sort ml-1 text-teal-200"></i>@endif
                    </a>
                </th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="produkTableBody" class="divide-y divide-gray-200">
            @forelse($produks as $i => $produk)
            <tr class="hover:bg-gray-50 transition " data-id="{{ $produk->id }}">
                <td class="px-4 py-2 font-medium text-gray-600">{{ $sortOrder == 'desc' ? $produks->total() - ($produks->firstItem() - 1) - $i : $i + $produks->firstItem() }}</td>
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