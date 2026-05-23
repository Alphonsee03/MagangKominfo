<x-header-admin title="Ubah Kata Sandi">
    <div class="min-h-screen bg-gradient-to-br from-teal-50 via-white to-blue-50 flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-teal-600 rounded-xl shadow-lg mb-3">
                    <i class="fas fa-lock text-white text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Ubah Kata Sandi</h1>
                <p class="text-sm text-gray-500 mt-1">Masukkan kata sandi baru Anda</p>
            </div>

            <!-- Alert Success -->
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-3 mb-4">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <!-- Alert Error -->
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-start gap-3 mb-4">
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
            @endif

            <!-- Card Form -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                <form action="{{ route('change-password.update') }}" method="POST">
                    @csrf

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi Saat Ini</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" name="current_password" required
                                    class="pl-10 pr-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                    placeholder="Masukkan kata sandi saat ini">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                    <i class="fas fa-eye text-gray-400"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi Baru</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400"></i>
                                </div>
                                <input type="password" name="password" required
                                    class="pl-10 pr-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                    placeholder="Masukkan kata sandi baru (min. 6 karakter)">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                    <i class="fas fa-eye text-gray-400"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400"></i>
                                </div>
                                <input type="password" name="password_confirmation" required
                                    class="pl-10 pr-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                    placeholder="Ulangi kata sandi baru">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                    <i class="fas fa-eye text-gray-400"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6 pt-5 border-t border-gray-100">
                        <button type="button" onclick="resetForm()"
                            class="px-4 py-2 text-sm text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all flex items-center gap-1.5">
                            <i class="fas fa-undo-alt"></i>
                            Reset
                        </button>
                        <div class="flex gap-2">
                            <a href="javascript:history.back()"
                                class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors">
                                Kembali
                            </a>
                            <button type="button" onclick="confirmSubmit()"
                                class="px-5 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors shadow-md flex items-center gap-2">
                                <i class="fas fa-save"></i>
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function resetForm() {
            if (!confirm('Apakah Anda yakin ingin mereset semua field?')) return;
            document.querySelectorAll('input[name="current_password"], input[name="password"], input[name="password_confirmation"]').forEach(input => input.value = '');
        }

        function confirmSubmit() {
            const current = document.querySelector('input[name="current_password"]').value;
            const baru = document.querySelector('input[name="password"]').value;
            const konfirmasi = document.querySelector('input[name="password_confirmation"]').value;

            if (!current || !baru || !konfirmasi) {
                alert('Harap isi semua field terlebih dahulu.');
                return;
            }

            if (baru !== konfirmasi) {
                alert('Konfirmasi kata sandi baru tidak cocok.');
                return;
            }

            if (!confirm('Apakah Anda yakin ingin mengubah kata sandi?')) return;
            document.querySelector('form').submit();
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
