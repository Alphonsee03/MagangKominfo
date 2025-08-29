<x-header-admin>
    <x-navbar />
    <x-topheader />
    <div class="pc-container">
        <div class="pc-content">
            <!-- Header Section -->
            <div class="mb-6">
                <div class="flex items-center mb-2">
                    <a href="{{ route('admin.users.index') }}" class="text-teal-600 hover:text-teal-800 mr-3">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-2xl font-bold text-teal-600">Edit Pengguna</h1>
                </div>
                <p class="text-gray-500 ml-7">Memperbarui informasi pengguna {{ $user->nama }}</p>
                <div class="border-b border-gray-200 mt-4"></div>
            </div>

            <div class="max-w-2xl mx-auto">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Form Container -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-user-edit text-teal-600 mr-2"></i> Informasi Pengguna
                            </h3>
                            <span class="px-3 py-1 text-xs font-medium rounded-full 
                            {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                               'bg-blue-100 text-blue-800' }}">
                                {{ $user->role }}
                            </span>
                        </div>

                        <div class="space-y-5">
                            <!-- Nama Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}"
                                        class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                        placeholder="Masukkan nama lengkap">
                                </div>
                            </div>

                            <!-- Username Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Username
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-at text-gray-400"></i>
                                    </div>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                        class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                        placeholder="Masukkan username">
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                        placeholder="Masukkan alamat email">
                                </div>
                            </div>

                            <!-- Password Field (Optional) -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-key text-teal-600 mr-2"></i>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Ubah Password (Opsional)
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500 mb-3">Kosongkan jika tidak ingin mengubah password</p>

                                <div class="space-y-3">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password" name="password"
                                            class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                            placeholder="Password baru">
                                    </div>

                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password" name="password_confirmation"
                                            class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                            placeholder="Konfirmasi password baru">
                                    </div>
                                </div>
                            </div>

                            <!-- Role Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Role
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
                                    <label class="relative flex cursor-pointer rounded-lg border border-gray-200 p-4 focus:outline-none 
                                    {{ old('role', $user->role) == 'admin' ? 'border-teal-300 bg-teal-50' : '' }}">
                                        <input type="radio" name="role" value="admin"
                                            {{ old('role', $user->role) == 'admin' ? 'checked' : '' }}
                                            class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                                        <div class="ml-3 flex flex-col">
                                            <span class="block text-sm font-medium text-gray-900">Admin</span>
                                            <span class="block text-sm text-gray-500">Akses penuh sistem</span>
                                        </div>
                                    </label>

                                    <label class="relative flex cursor-pointer rounded-lg border border-gray-200 p-4 focus:outline-none 
                                    {{ old('role', $user->role) == 'kasir' ? 'border-teal-300 bg-teal-50' : '' }}">
                                        <input type="radio" name="role" value="kasir"
                                            {{ old('role', $user->role) == 'kasir' ? 'checked' : '' }}
                                            class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                                        <div class="ml-3 flex flex-col">
                                            <span class="block text-sm font-medium text-gray-900">Kasir</span>
                                            <span class="block text-sm text-gray-500">Akses point of sale</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Info & Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="text-sm text-gray-500">
                            <p>Terdaftar: {{ $user->created_at->format('d M Y') }}</p>
                            <p>Terakhir update: {{ $user->updated_at->format('d M Y H:i') }}</p>
                        </div>

                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.users.index') }}"
                                class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-5 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors shadow-md flex items-center">
                                <i class="fas fa-save mr-2"></i> Perbarui
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

   
    

    <style>
        .transition-colors {
            transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
        }

        input[type="radio"]:checked+div {
            border-color: #0d9488;
            background-color: #f0fdfa;
        }
    </style>
    <x-script-admin />
</x-header-admin>