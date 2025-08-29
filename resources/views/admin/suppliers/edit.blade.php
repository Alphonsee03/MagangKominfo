<x-header-admin> 
    <style>
        .focus\:ring-teal-500:focus {
            --tw-ring-color: rgba(5, 150, 105, 0.5);
            box-shadow: 0 0 0 3px var(--tw-ring-color);
        }

        .transition-colors {
            transition-property: color, background-color, border-color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
    <x-navbar />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">
            <!-- Header Section -->
            <div class="mb-6">
                <div class="flex items-center mb-2">
                    <a href="{{ route('admin.suppliers.index') }}" class="text-teal-600 hover:text-teal-800 mr-3">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="text-2xl font-bold text-teal-600">Edit Supplier</h2>
                </div>
                <p class="text-gray-500 ml-7">Memperbarui informasi supplier {{ $supplier->nama }}</p>
                <div class="border-b border-gray-200 mt-4"></div>
            </div>

            <!-- Form Container -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Supplier Field -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Supplier
                        </label>
                        <input type="text" name="nama" value="{{ old('nama', $supplier->nama) }}"
                            class="w-full border border-gray-300 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                            placeholder="Masukkan nama supplier">
                        @error('nama')
                        <p class="text-red-600 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Telepon Field -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Telepon
                        </label>
                        <input type="text" name="telepon" value="{{ old('telepon', $supplier->telepon) }}"
                            class="w-full border border-gray-300 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                            placeholder="Masukkan nomor telepon">
                        @error('telepon')
                        <p class="text-red-600 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Alamat Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat
                        </label>
                        <textarea name="alamat"
                            class="w-full border border-gray-300 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                            rows="3"
                            placeholder="Masukkan alamat lengkap supplier">{{ old('alamat', $supplier->alamat) }}</textarea>
                        @error('alamat')
                        <p class="text-red-600 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.suppliers.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition-colors shadow-sm">
                            <i class="fas fa-check-circle mr-1.5"></i> Perbarui
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mt-5">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                        <div class="mt-1 text-sm text-blue-700">
                            <p>
                                Terakhir diperbarui: 
                                {{ $supplier->updated_at->format('d M Y h:i') }} {{ $supplier->updated_at->format('A') == 'AM' ? 'AM' : 'PM' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <x-script-admin />
</x-header-admin>