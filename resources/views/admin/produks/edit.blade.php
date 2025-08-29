<x-header-admin>
    <x-navbar />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">
            <h2 class="text-2xl font-bold text-teal-600 mb-4">Edit Produk</h2>

            {{-- Alert --}}
            <div id="alertBox" class="hidden px-4 py-2 rounded mb-4"></div>

            <form id="editProdukForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $produk->id }}">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1">Kode Produk</label>
                        <input type="text" name="kode_produk" value="{{ $produk->kode_produk }}" class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Nama Produk</label>
                        <input type="text" name="nama" value="{{ $produk->nama }}" class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Harga Beli</label>
                        <input type="number" name="harga_beli" value="{{ $produk->harga_beli }}" class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Harga Jual</label>
                        <input type="number" name="harga_jual" value="{{ $produk->harga_jual }}" class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Stok</label>
                        <input type="number" name="stok" value="{{ $produk->stok }}" class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Deskripsi</label>
                        <textarea name="deskripsi" class="w-full border px-3 py-2 rounded">{{ $produk->deskripsi }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block mb-1">Foto Produk</label>
                    <input type="file" name="foto" id="foto" class="w-full border px-3 py-2 rounded">
                    @if($produk->foto)
                    <img src="{{ asset('storage/'.$produk->foto) }}" class="h-16 mt-2 rounded">
                    @endif
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Update</button>
                    <a href="{{ route('admin.produks.index') }}" class="ml-2 text-gray-600">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <x-script-admin />
    <script>
        const formEdit = document.getElementById("editProdukForm");
        const alertBox = document.getElementById("alertBox");
        const id = "{{ $produk->id }}";

        formEdit.addEventListener("submit", function(e) {
            e.preventDefault();

            let formData = new FormData(formEdit);

            fetch("/admin/produks/" + id, {
                    method: "POST", // Laravel butuh POST + @method PUT
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alertBox.innerText = data.message;
                        alertBox.className = "bg-green-100 text-green-700 px-4 py-2 rounded mb-4";
                        alertBox.classList.remove("hidden");
                    } else {
                        alertBox.innerText = "Gagal update produk!";
                        alertBox.className = "bg-red-100 text-red-700 px-4 py-2 rounded mb-4";
                        alertBox.classList.remove("hidden");
                    }
                })
                .catch(err => console.error(err));
        });
    </script>
</x-header-admin>