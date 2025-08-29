<x-header-admin>
    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-hover tr {
            transition: background-color 0.2s ease;
        }

        .table-hover tr:hover {
            background-color: #f8fafc;
        }
    </style>
    <x-navbar />
    <x-topheader />

    <div class="pc-container ">
        <div class="pc-content">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 animate-fade-in">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.produks.index') }}">
                        <i data-feather="arrow-left" class="text-emerald-700"></i>
                    </a>
                    <div>
                        <h2 class="text-2xl font-bold text-teal-600">Daftar Supplier</h2>
                        <p class="text-gray-500 mt-1">Kelola data supplier dan pemasok barang</p>
                    </div>
                </div>
                <a href="{{ route('admin.suppliers.create') }}"
                    class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors shadow-md">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Supplier
                </a>
            </div>

            <!-- Table Container -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden animate-fade-in" style="animation-delay: 0.1s">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-teal-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">Nama Supplier</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">Telepon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">Alamat</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-teal-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 table-hover">
                            @foreach ($suppliers as $supplier)
                            <tr class="animate-fade-in">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-teal-100 rounded-full flex items-center justify-center">
                                            <span class="text-teal-600 font-semibold">{{ substr($supplier->nama, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $supplier->nama }}</div>
                                            <div class="text-sm text-gray-500">{{ $supplier->email ?? 'Tidak ada email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $supplier->telepon }}</div>
                                    <div class="text-sm text-gray-500">WhatsApp: </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">{{ $supplier->alamat }}</div>
                                    <div class="text-sm text-gray-500">{{ $supplier->kota ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('admin.suppliers.edit', $supplier->id) }}"
                                            class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors"
                                            title="Edit Supplier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus supplier {{ $supplier->nama }}?')"
                                                title="Hapus Supplier">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        <a href="#"
                                            class="text-teal-600 hover:text-teal-900 bg-teal-50 hover:bg-teal-100 p-2 rounded-lg transition-colors"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer with Pagination (jika ada) -->
                @if($suppliers->hasPages())
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
                    {{ $suppliers->links() }}
                </div>
                @endif
            </div>

            <!-- Empty State -->
            @if($suppliers->count() == 0)
            <div class="bg-white rounded-lg shadow-md p-8 text-center mt-6 animate-fade-in">
                <div class="text-teal-500 text-5xl mb-4">
                    <i class="fas fa-truck-loading"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada supplier</h3>
                <p class="text-gray-500 mb-4">Tambahkan supplier pertama Anda untuk mulai mengelola pemasok barang.</p>
                <a href="{{ route('admin.suppliers.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-white hover:bg-teal-700 transition-colors">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Supplier
                </a>
            </div>
            @endif
        </div>
    </div>

    <script>
        // Menambahkan efek animasi pada tabel
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.05}s`;
            });
        });
    </script>




    <x-script-admin />
</x-header-admin>