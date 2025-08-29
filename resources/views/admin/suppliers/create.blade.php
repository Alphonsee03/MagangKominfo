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
    </style>
    <x-navbar />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">
            <!-- Header Section -->
            <div class="mb-6 animate-fade-in">
                <h2 class="text-2xl font-bold text-teal-600">Tambah Supplier Baru</h2>
                <p class="text-gray-500 mt-1">Lengkapi form berikut untuk menambahkan supplier baru</p>
                <div class="border-b border-gray-200 mt-4"></div>
            </div>

            <!-- Form Container -->
            <div class="bg-white rounded-xl shadow-md p-6 animate-fade-in" style="animation-delay: 0.1s">
                <form action="{{ route('admin.suppliers.store') }}" method="POST">
                    @csrf

                    <!-- Nama Supplier Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Supplier <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-building text-gray-400"></i>
                            </div>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                placeholder="Masukkan nama supplier">
                        </div>
                        @error('nama')
                        <p class="text-red-600 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Telepon Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Telepon
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                            <input type="text" name="telepon" value="{{ old('telepon') }}"
                                class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                placeholder="Masukkan nomor telepon">
                        </div>
                        @error('telepon')
                        <p class="text-red-600 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Alamat Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-3 pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <textarea name="alamat"
                                class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                rows="4"
                                placeholder="Masukkan alamat lengkap supplier">{{ old('alamat') }}</textarea>
                        </div>
                        @error('alamat')
                        <p class="text-red-600 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.suppliers.index') }}"
                            class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center">
                            <i class="fas fa-times-circle mr-2"></i> Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors flex items-center shadow-md">
                            <i class="fas fa-save mr-2"></i> Simpan Supplier
                        </button>
                    </div>
                </form>
            </div>

            <!-- Informasi Card -->
            <div class="bg-teal-50 border border-teal-200 rounded-xl p-5 mt-6 animate-fade-in" style="animation-delay: 0.2s">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-teal-100 flex items-center justify-center mt-0.5">
                        <i class="fas fa-info-circle text-teal-600 text-xs"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-teal-800">Tips mengisi data supplier</h3>
                        <div class="mt-2 text-sm text-teal-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Pastikan nama supplier jelas dan mudah dikenali</li>
                                <li>Isi nomor telepon yang aktif untuk memudahkan komunikasi</li>
                                <li>Alamat lengkap membantu dalam proses pengiriman barang</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-script-admin />
</x-header-admin>