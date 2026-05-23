<x-header-admin>
    <style>
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        .animate-slide-up {
            animation: slideUp 0.5s ease-out forwards;
        }
        .animate-scale-in {
            animation: scaleIn 0.4s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .radio-card {
            transition: all 0.2s ease;
        }
        .radio-card:hover {
            border-color: #14b8a6;
            background-color: #f0fdfa;
        }
        input[type="radio"]:checked + .radio-card-content {
            border-color: #0d9488;
        }
        .radio-card:has(input:checked) {
            border-color: #0d9488;
            background-color: #f0fdfa;
            box-shadow: 0 0 0 1px #0d9488;
        }
        .input-field {
            transition: all 0.2s ease;
        }
        .input-field:focus {
            box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1);
        }
        .btn-hover-effect {
            transition: all 0.25s ease;
        }
        .btn-hover-effect:hover {
            transform: translateY(-1px);
        }
        .bg-grid-pattern {
            background-image: 
                linear-gradient(rgba(13, 148, 136, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(13, 148, 136, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .modal-overlay {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            transition: all 0.3s ease;
        }
        .modal-overlay.hidden {
            display: none;
        }
        .modal-card {
            animation: modalPop 0.35s ease-out forwards;
        }
        @keyframes modalPop {
            from { opacity: 0; transform: scale(0.92) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>
    <x-navbar />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">

            <!-- Decorative Background -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none -z-10">
                <div class="bg-grid-pattern absolute inset-0"></div>
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-50 rounded-full opacity-50 blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-50 rounded-full opacity-30 blur-3xl"></div>
            </div>

            <!-- Header Section -->
            <div class="mb-8 animate-fade-in">
                <div class="flex items-center gap-3 mb-3">
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 text-teal-600 hover:bg-teal-50 hover:border-teal-200 transition-all">
                        <i class="fas fa-arrow-left text-sm"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Edit Pengguna</h1>
                        <p class="text-sm text-gray-500 mt-0.5">Memperbarui informasi pengguna {{ $user->nama }}</p>
                    </div>
                    <span class="ml-auto px-3 py-1 text-xs font-semibold rounded-full 
                        {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700 ring-1 ring-purple-300' : 
                           ($user->role == 'kasir' ? 'bg-blue-100 text-blue-700 ring-1 ring-blue-300' : 
                            'bg-amber-100 text-amber-700 ring-1 ring-amber-300') }}">
                        <i class="fas fa-{{ $user->role == 'admin' ? 'shield-alt' : ($user->role == 'kasir' ? 'cash-register' : 'truck') }} mr-1"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                <div class="relative">
                    <div class="border-b border-gray-200"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-0.5 bg-gradient-to-r from-teal-500 to-teal-300 rounded-full"></div>
                </div>
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
                <form id="editUserForm" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Form Card -->
                    <div class="bg-white rounded-xl shadow-lg shadow-gray-200/50 border border-gray-100 p-7 animate-slide-up" style="animation-delay: 0.1s">
                        <!-- Card Header -->
                        <div class="flex items-center gap-3 pb-5 mb-6 border-b border-gray-100">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-teal-50 text-teal-600">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Informasi Pengguna</h3>
                                <p class="text-xs text-gray-500">Lengkapi data pengguna dengan benar</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <!-- Nama Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Nama Lengkap
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}"
                                        class="input-field pl-10 w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                        placeholder="Masukkan nama lengkap">
                                </div>
                                @error('nama')
                                <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1.5">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Username Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Username
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-at text-gray-400"></i>
                                    </div>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                        class="input-field pl-10 w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                        placeholder="Masukkan username">
                                </div>
                                @error('username')
                                <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1.5">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Email
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="input-field pl-10 w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                        placeholder="Masukkan alamat email">
                                </div>
                                @error('email')
                                <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1.5">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Divider -->
                            <div class="border-t border-gray-100 pt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Role Pengguna
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <label class="radio-card relative flex cursor-pointer rounded-xl border border-gray-200 p-4 focus:outline-none">
                                        <input type="radio" name="role" value="admin"
                                            {{ old('role', $user->role) == 'admin' ? 'checked' : '' }}
                                            class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500 mt-0.5">
                                        <div class="ml-3 flex flex-col">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-lg bg-purple-100 flex items-center justify-center">
                                                    <i class="fas fa-shield-alt text-purple-600 text-xs"></i>
                                                </div>
                                                <span class="block text-sm font-medium text-gray-900">Admin</span>
                                            </div>
                                            <span class="block text-xs text-gray-500 mt-1.5 ml-9">Akses penuh ke seluruh sistem</span>
                                        </div>
                                    </label>

                                    <label class="radio-card relative flex cursor-pointer rounded-xl border border-gray-200 p-4 focus:outline-none">
                                        <input type="radio" name="role" value="kasir"
                                            {{ old('role', $user->role) == 'kasir' ? 'checked' : '' }}
                                            class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500 mt-0.5">
                                        <div class="ml-3 flex flex-col">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center">
                                                    <i class="fas fa-cash-register text-blue-600 text-xs"></i>
                                                </div>
                                                <span class="block text-sm font-medium text-gray-900">Kasir</span>
                                            </div>
                                            <span class="block text-xs text-gray-500 mt-1.5 ml-9">Akses transaksi point of sale</span>
                                        </div>
                                    </label>
                                </div>
                                @error('role')
                                <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1.5">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                                @enderror
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

                    <!-- Info & Action Section -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 mt-6 animate-slide-up" style="animation-delay: 0.2s">
                        <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="flex -space-x-1">
                                <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-teal-600 text-xs"></i>
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 leading-relaxed">
                                <span class="text-gray-700 font-medium">Terdaftar</span> {{ $user->created_at->format('d M Y') }}<br>
                                <span class="text-gray-700 font-medium">Terakhir diubah</span> {{ $user->updated_at->format('d M Y H:i') }}
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5">
                            <a href="{{ route('admin.users.index') }}"
                                class="btn-hover-effect px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all flex items-center gap-2">
                                <i class="fas fa-times-circle text-gray-400"></i>
                                Batal
                            </a>
                            <button type="button" onclick="openModal()"
                                class="btn-hover-effect px-6 py-2.5 bg-gradient-to-r from-teal-600 to-teal-500 text-white rounded-lg hover:from-teal-700 hover:to-teal-600 transition-all shadow-md shadow-teal-200 hover:shadow-lg hover:shadow-teal-300 flex items-center gap-2">
                                <i class="fas fa-save"></i>
                                Perbarui
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Verification Modal -->
    <div id="verificationModal" class="modal-overlay hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="modal-card bg-white rounded-xl shadow-2xl border border-gray-100 w-full max-w-md">
            <!-- Modal Header -->
            <div class="flex items-center gap-3 px-6 pt-6 pb-4 border-b border-gray-100">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-50 text-amber-600">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Verifikasi Perubahan</h3>
                    <p class="text-xs text-gray-500">Pastikan data yang diubah sudah benar</p>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-5 space-y-3">
                <div class="flex items-center justify-between py-2.5 px-4 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-600">Nama</span>
                    <span class="text-sm font-medium text-gray-900" id="verifyNama">{{ $user->nama }}</span>
                </div>
                <div class="flex items-center justify-between py-2.5 px-4 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-600">Username</span>
                    <span class="text-sm font-medium text-gray-900" id="verifyUsername">{{ $user->username }}</span>
                </div>
                <div class="flex items-center justify-between py-2.5 px-4 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-600">Email</span>
                    <span class="text-sm font-medium text-gray-900" id="verifyEmail">{{ $user->email }}</span>
                </div>
                <div class="flex items-center justify-between py-2.5 px-4 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-600">Role</span>
                    <span class="text-sm font-medium text-gray-900" id="verifyRole">{{ ucfirst($user->role) }}</span>
                </div>
            </div>

            <!-- Modal Info -->
            <div class="mx-6 mb-4 bg-gradient-to-r from-teal-50 to-teal-50/50 border border-teal-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-7 h-7 rounded-lg bg-teal-100 flex items-center justify-center">
                        <i class="fas fa-info-circle text-teal-600 text-xs"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-teal-800">Informasi</h4>
                        <p class="text-xs text-teal-700 mt-0.5 leading-relaxed">
                            Perubahan yang disimpan akan langsung diterapkan. Pastikan data di atas sudah benar.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-2.5 px-6 pb-6 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()"
                    class="btn-hover-effect px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all flex items-center gap-2">
                    <i class="fas fa-arrow-left text-gray-400"></i>
                    Kembali
                </button>
                <button type="button" onclick="submitForm()"
                    class="btn-hover-effect px-6 py-2.5 bg-gradient-to-r from-teal-600 to-teal-500 text-white rounded-lg hover:from-teal-700 hover:to-teal-600 transition-all shadow-md shadow-teal-200 hover:shadow-lg hover:shadow-teal-300 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <script>
        function resetForm() {
            if (!confirm('Apakah Anda yakin ingin mereset semua field?')) return;
            document.getElementById('editUserForm').reset();
        }

        function openModal() {
            const nama = document.querySelector('input[name="nama"]').value;
            const username = document.querySelector('input[name="username"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const role = document.querySelector('input[name="role"]:checked');
            const roleText = role ? role.value.charAt(0).toUpperCase() + role.value.slice(1) : '';

            document.getElementById('verifyNama').textContent = nama;
            document.getElementById('verifyUsername').textContent = username;
            document.getElementById('verifyEmail').textContent = email;
            document.getElementById('verifyRole').textContent = roleText;

            document.getElementById('verificationModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('verificationModal').classList.add('hidden');
        }

        function submitForm() {
            document.getElementById('editUserForm').submit();
        }

        document.getElementById('verificationModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
    <x-script-admin />
</x-header-admin>
