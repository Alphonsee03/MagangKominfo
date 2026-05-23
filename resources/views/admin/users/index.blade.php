<x-header-admin title="Manajemen Pengguna">
    <x-navbar />
    <x-topheader />
    <div class="pc-container">
        <div class="pc-content">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 p-6 pb-0">
                <div>
                    <h1 class="text-2xl font-bold text-teal-600">Manajemen Pengguna</h1>
                    <p class="text-gray-500 mt-1">Kelola data pengguna sistem</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                    class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2.5 rounded-lg flex items-center transition-colors shadow-sm">
                    <i class="fas fa-user-plus mr-2"></i> Tambah User
                </a>
            </div>

            <div class="p-6 pt-0">
                <!-- Search -->
                <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
                    <div class="relative max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, username, atau email..."
                            class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                    </div>
                    <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                    <input type="hidden" name="sort_order" value="{{ $sortOrder }}">
                </form>

                <!-- Table Container -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-teal-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">
                                        <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => $sortBy == 'id' && $sortOrder == 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-teal-800">
                                            No. @if($sortBy == 'id')<i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }} ml-1"></i>@else<i class="fas fa-sort ml-1 text-teal-300"></i>@endif
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">
                                        <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort_by' => 'nama', 'sort_order' => $sortBy == 'nama' && $sortOrder == 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-teal-800">
                                            User @if($sortBy == 'nama')<i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }} ml-1"></i>@else<i class="fas fa-sort ml-1 text-teal-300"></i>@endif
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">
                                        <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort_by' => 'username', 'sort_order' => $sortBy == 'username' && $sortOrder == 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-teal-800">
                                            Username @if($sortBy == 'username')<i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }} ml-1"></i>@else<i class="fas fa-sort ml-1 text-teal-300"></i>@endif
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">
                                        <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort_by' => 'email', 'sort_order' => $sortBy == 'email' && $sortOrder == 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-teal-800">
                                            Email @if($sortBy == 'email')<i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }} ml-1"></i>@else<i class="fas fa-sort ml-1 text-teal-300"></i>@endif
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-teal-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                <tr class="transition-colors hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">{{ $sortOrder == 'desc' ? $users->count() - $loop->index : $loop->iteration }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-teal-100 rounded-full flex items-center justify-center">
                                                <span class="text-teal-600 font-semibold">{{ substr($user->nama, 0, 1) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->nama }}</div>
                                                <div class="text-sm text-gray-500">Terdaftar: {{ $user->created_at->format('d M Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $user->username }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                           ($user->role == 'kasir' ? 'bg-blue-100 text-blue-800' : 
                                           'bg-gray-100 text-yellow-400') }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors"
                                                title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors"
                                                    onclick="return confirm('Yakin hapus user {{ $user->nama }}?')"
                                                    title="Hapus User">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    @if($users->count() == 0)
                    <div class="p-8 text-center">
                        <div class="text-teal-500 text-5xl mb-4">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada pengguna</h3>
                        <p class="text-gray-500 mb-4">Tambahkan pengguna pertama untuk mengelola sistem.</p>
                        <a href="{{ route('admin.users.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-white hover:bg-teal-700 transition-colors">
                            <i class="fas fa-user-plus mr-2"></i> Tambah User
                        </a>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>


    
    <style>
        .transition-colors {
            transition: color 0.2s ease, background-color 0.2s ease;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            const form = searchInput?.closest('form');
            let timeout;
            searchInput?.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => form?.requestSubmit(), 500);
            });
        });
    </script>
    <x-script-admin />
</x-header-admin>