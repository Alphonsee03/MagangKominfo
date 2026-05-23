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
                    <h1 class="text-2xl font-bold text-teal-600">Tambah Pengguna Baru</h1>
                </div>
                <p class="text-gray-500 ml-7">Lengkapi form berikut untuk menambahkan pengguna baru</p>
                <div class="border-b border-gray-200 mt-4"></div>
            </div>

            @if($errors->any())
            <div class="max-w-2xl mx-auto mb-4">
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-start gap-3">
                    <i class="fas fa-exclamation-circle mt-0.5"></i>
                    <div>
                        <span class="font-medium">Terjadi kesalahan:</span>
                        <ul class="list-disc list-inside text-sm mt-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="max-w-2xl mx-auto">
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Form Container -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user-plus text-teal-600 mr-2"></i> Informasi Pengguna
                        </h3>

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
                                    <input type="text" name="nama" value="{{ old('nama', $user->nama ?? '') }}"
                                        class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors @error('nama') border-red-400 @enderror"
                                        placeholder="Masukkan nama lengkap">
                                </div>
                                @error('nama')
                                <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1.5"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
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
                                    <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}"
                                        class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors @error('username') border-red-400 @enderror"
                                        placeholder="Masukkan username">
                                </div>
                                @error('username')
                                <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1.5"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
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
                                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                                        class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors @error('email') border-red-400 @enderror"
                                        placeholder="Masukkan alamat email">
                                </div>
                                @error('email')
                                <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1.5"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Password 
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" name="password"
                                        class="pl-10 pr-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors @error('password') border-red-400 @enderror"
                                        placeholder="Masukkan password">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                        <i class="fas fa-eye text-gray-400"></i>
                                    </button>
                                </div>
                                @error('password')
                                <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1.5"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Konfirmasi Password 
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" name="password_confirmation"
                                        class="pl-10 pr-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                        placeholder="Konfirmasi password">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                        <i class="fas fa-eye text-gray-400"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Role Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Role 
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
                                    <label class="relative flex cursor-pointer rounded-lg border border-gray-200 p-4 focus:outline-none">
                                        <input type="radio" name="role" value="admin"
                                            {{ old('role', $user->role ?? '') == 'admin' ? 'checked' : '' }}
                                            class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                                        <div class="ml-3 flex flex-col">
                                            <span class="block text-sm font-medium text-gray-900">Admin</span>
                                            <span class="block text-sm text-gray-500">Akses penuh sistem</span>
                                        </div>
                                    </label>

                                    <label class="relative flex cursor-pointer rounded-lg border border-gray-200 p-4 focus:outline-none">
                                        <input type="radio" name="role" value="kasir"
                                            {{ old('role', $user->role ?? '') == 'kasir' ? 'checked' : '' }}
                                            class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                                        <div class="ml-3 flex flex-col">
                                            <span class="block text-sm font-medium text-gray-900">Kasir</span>
                                            <span class="block text-sm text-gray-500">Akses point of sale</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Reset -->
                        <div class="flex justify-end pt-4 border-t border-gray-100 mt-6">
                            <button type="button" onclick="resetForm()"
                                class="px-4 py-2 text-sm text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all flex items-center gap-1.5">
                                <i class="fas fa-undo-alt"></i>
                                Reset All
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.users.index') }}"
                            class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors shadow-md flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Pengguna
                        </button>
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
    <script>
        function resetForm() {
            if (!confirm('Apakah Anda yakin ingin mereset semua field?')) return;

            const form = document.querySelector('form');
            form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]').forEach(input => input.value = '');
            form.querySelectorAll('input[type="radio"]').forEach(radio => radio.checked = false);
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.toggle-password').forEach(btn => {
                btn.addEventListener('click', () => {
                    const input = btn.closest('.relative').querySelector('input');
                    const icon = btn.querySelector('i');
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.className = 'fas fa-eye-slash text-gray-400';
                    } else {
                        input.type = 'password';
                        icon.className = 'fas fa-eye text-gray-400';
                    }
                });
            });
        });
    </script>
    <x-script-admin />
</x-header-admin>