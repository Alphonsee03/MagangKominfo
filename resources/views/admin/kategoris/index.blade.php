<x-header-admin>
    <x-navbar />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.produks.index') }}">
                        <i data-feather="arrow-left" class="text-emerald-700"></i>
                    </a>
                    <div>
                        <h2 class="text-2xl font-bold text-teal-600">Daftar Kategori</h2>
                        <p class="text-gray-500 mt-1 text-sm">Kelola kategori produk Anda</p>
                    </div>
                </div>
                <a href="{{ route('admin.kategoris.create') }}"
                    class="bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded-lg flex items-center transition-colors shadow-sm text-sm">
                    <i class="fas fa-plus mr-2"></i> Tambah Kategori
                </a>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3">
                @foreach($kategoris as $kategori)
                @php
                // Generate different colors based on category ID for variety
                $colors = [
                'bg-blue-100 text-blue-800 border-blue-200',
                'bg-teal-100 text-teal-800 border-teal-200',
                'bg-purple-100 text-purple-800 border-purple-200',
                'bg-amber-100 text-amber-800 border-amber-200',
                'bg-rose-100 text-rose-800 border-rose-200',
                'bg-emerald-100 text-emerald-800 border-emerald-200',
                'bg-indigo-100 text-indigo-800 border-indigo-200',
                'bg-cyan-100 text-cyan-800 border-cyan-200',
                ];
                $colorClass = $colors[$kategori->id % count($colors)];
                @endphp
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow p-3 group">
                    <!-- Colorful header -->
                    <div class="{{ $colorClass }} rounded-md p-2 mb-2 text-center">
                        <span class="text-xs font-semibold">{{ $kategori->nama }}</span>
                    </div>

                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs text-gray-500 font-mono">No.{{ $kategori->id }}</span>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">
                            {{ $kategori->produks_count }} produk
                        </span>
                    </div>


                    <!-- Action buttons -->
                    <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                        <span class="text-xs text-gray-400 group-hover:text-teal-600 transition-colors">
                            <i class="fas fa-boxes mr-1"></i> Kategori
                        </span>
                        <div class="flex space-x-1">
                            <a href="{{ route('admin.kategoris.edit', $kategori->id) }}"
                                class="text-blue-400 hover:text-blue-600 p-1 rounded-full hover:bg-blue-50 transition-colors"
                                title="Edit Kategori">
                                <i class="fas fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.kategoris.destroy', $kategori->id) }}"
                                method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-400 hover:text-red-600 p-1 rounded-full hover:bg-red-50 transition-colors"
                                    onclick="return confirm('Yakin hapus kategori {{ $kategori->nama }}?')"
                                    title="Hapus Kategori">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($kategoris->count() == 0)
            <div class="bg-white rounded-lg border border-dashed border-gray-300 p-6 text-center mt-6">
                <div class="text-teal-400 text-4xl mb-3">
                    <i class="fas fa-tags"></i>
                </div>
                <h3 class="text-base font-medium text-gray-700 mb-1">Belum ada kategori</h3>
                <p class="text-gray-500 text-sm mb-4">Tambahkan kategori pertama Anda untuk mengelompokkan produk.</p>
                <a href="{{ route('admin.kategoris.create') }}"
                    class="inline-flex items-center px-3 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-white hover:bg-teal-700 transition-colors text-sm">
                    <i class="fas fa-plus mr-2"></i> Tambah Kategori
                </a>
            </div>
            @endif

            <!-- Pagination -->
            @if($kategoris->hasPages())
            <div class="mt-4 bg-white rounded-lg border border-gray-200 px-4 py-3">
                {{ $kategoris->links() }}
            </div>
            @endif
        </div>
    </div>


    <style>
        .transition-colors {
            transition: color 0.2s ease, background-color 0.2s ease;
        }

        .transition-shadow {
            transition: box-shadow 0.2s ease;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
        }
    </style>

    <x-script-admin />
</x-header-admin>