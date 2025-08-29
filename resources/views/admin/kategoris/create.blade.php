<x-header-admin>
    <x-navbar/>
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">
            <h2 class="font-bold text-2xl mb-4">Tambah Kategori</h2>

            <form action="{{ route('admin.kategoris.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1">Nama Kategori</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           class="w-full border rounded px-3 py-2">
                    @error('nama') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
                <a href="{{ route('admin.kategoris.index') }}" class="ml-2 text-gray-600">Batal</a>
            </form>
        </div>
    </div>

    <x-script-admin />
</x-header-admin>
