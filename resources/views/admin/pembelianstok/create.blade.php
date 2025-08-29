<x-header-admin>
    <x-navbar />
    <x-topheader />

    <div class="pc-container">
        <div class="pc-content">
            @error('produk_id') <div class="text-red-500">{{ $message }}</div> @enderror
@error('produk_id.*') <div class="text-red-500">{{ $message }}</div> @enderror


            <h2 class="font-bold text-2xl text-teal-600 mb-4">Pembelian Stok</h2>

            <form action="{{ route('admin.pembelians.store') }}" method="POST" id="formPembelian">
                @csrf

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1">Supplier</label>
                        <select id="supplier_id" name="supplier_id" class="w-full border px-3 py-2 rounded">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block mb-1">Filter Kategori</label>
                        <select id="filter_kategori" class="w-full border px-3 py-2 rounded">
                            <option value="">-- Semua Kategori --</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 overflow-x-auto bg-white shadow rounded-lg">
                    <table class="w-full text-sm text-left border border-gray-200">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-3 py-2 border">Pilih</th>
                                <th class="px-3 py-2 border">Nama</th>
                                <th class="px-3 py-2 border">Kategori</th>
                                <th class="px-3 py-2 border">Harga Beli</th>
                                <th class="px-3 py-2 border">Stok Supplier</th>
                                <th class="px-3 py-2 border">Jumlah Beli</th>
                                <th class="px-3 py-2 border">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="produkContainer">
                            <tr>
                                <td colspan="7" class="text-center p-4">Pilih supplier untuk melihat produk.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-right text-lg font-bold">
                    Total: Rp<span id="grandTotal">0</span>
                </div>

                <div class="mt-6 flex gap-2">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        Simpan
                    </button>
                    <a href="{{ route('admin.pembelians.index') }}" class="bg-gray-100 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <x-script-admin />
</x-header-admin>

{{-- JS khusus halaman ini --}}
<script>
    const supplierSelect = document.getElementById('supplier_id');
    const kategoriFilter = document.getElementById('filter_kategori');
    const produkContainer = document.getElementById('produkContainer');
    const grandTotalEl = document.getElementById('grandTotal');

    function rupiah(n) {
        const v = Number(n || 0);
        return v.toLocaleString('id-ID');
    }

    function recalcTotal() {
        let total = 0;
        document.querySelectorAll('.row-subtotal').forEach(s => {
            total += Number(s.dataset.value || 0);
        });
        grandTotalEl.textContent = rupiah(total);
    }

    function bindRowEvents() {
        document.querySelectorAll('.row-check').forEach(chk => {
            chk.addEventListener('change', function() {
                const id = this.value;
                const qty = document.getElementById(`qty-${id}`);
                if (this.checked) {
                    qty.removeAttribute('readonly');
                    if (qty.value == "0" || qty.value == "") qty.value = 1;
                } else {
                    qty.value = 0;
                    qty.setAttribute('readonly', 'readonly');
                }
                qty.dispatchEvent(new Event('input'));
            });
        });

        document.querySelectorAll('.row-qty').forEach(inp => {
            inp.addEventListener('input', function() {
                const id = this.dataset.id;
                const harga = Number(document.getElementById(`harga-${id}`).dataset.harga);
                const qty = Number(this.value || 0);
                const sub = harga * qty;

                const subEl = document.getElementById(`subtotal-${id}`);
                subEl.textContent = rupiah(sub);
                subEl.dataset.value = sub;

                recalcTotal();
            });
        });
    }

    document.querySelectorAll('.row-check').forEach(chk => {
        chk.addEventListener('change', function() {
            const id = this.value;
            const qty = document.getElementById(`qty-${id}`);
            if (this.checked) {
                qty.removeAttribute('disabled');
                if (!qty.value) qty.value = 1;
            } else {
                qty.value = '';
                qty.setAttribute('disabled', 'disabled');
                document.getElementById(`subtotal-${id}`).textContent = '0';
                document.getElementById(`subtotal-${id}`).dataset.value = 0;
            }
            // trigger subtotal recalc
            qty.dispatchEvent(new Event('input'));
        });
    });

    document.querySelectorAll('.row-qty').forEach(inp => {
        inp.addEventListener('input', function() {
            const id = this.dataset.id;
            const harga = Number(document.getElementById(`harga-${id}`).dataset.harga);
            const qty = Number(this.value || 0);
            const sub = harga * qty;

            const subEl = document.getElementById(`subtotal-${id}`);
            subEl.textContent = rupiah(sub);
            subEl.dataset.value = sub;

            recalcTotal();
        });
    });

    document.getElementById('formPembelian').addEventListener('submit', () => {
    document.querySelectorAll('.row-check:checked').forEach(chk => {
        const id = chk.value;
        const qty = document.getElementById(`qty-${id}`);
        if (!qty.value || qty.value == "0") qty.value = 1; // default minimal 1
        qty.removeAttribute('readonly'); // pastikan terkirim
    });
});



    function renderProduk(rows) {
    if (!rows.length) {
        produkContainer.innerHTML = `<tr><td colspan="6" class="text-center p-4">Tidak ada produk.</td></tr>`;
        return;
    }

    produkContainer.innerHTML = rows.map(p => `
        <tr class="hover:bg-gray-50">
          <td class="px-3 py-2 border">${p.nama}
            <input type="hidden" name="produk_id[]" value="${p.id}">
          </td>
          <td class="px-3 py-2 border">${p.kategori ? p.kategori.nama : '-'}</td>
          <td class="px-3 py-2 border">
            <span id="harga-${p.id}" data-harga="${p.harga_beli}">
              Rp${rupiah(p.harga_beli)}
            </span>
          </td>
          <td class="px-3 py-2 border">${p.stok_supplier ?? 0}</td>
          <td class="px-3 py-2 border">
            <input type="number" min="0" class="row-qty border px-2 py-1 w-24 rounded"
                   id="qty-${p.id}" data-id="${p.id}" name="jumlah[${p.id}]" value="0">
          </td>
          <td class="px-3 py-2 border">
            <span class="row-subtotal" id="subtotal-${p.id}" data-value="0">0</span>
          </td>
        </tr>
    `).join('');

    bindRowEvents();
}


    function loadProduk() {
        const supplierId = supplierSelect.value;
        const kategoriId = kategoriFilter.value;

        if (!supplierId) {
            produkContainer.innerHTML = `<tr><td colspan="7" class="text-center p-4">Pilih supplier untuk melihat produk.</td></tr>`;
            grandTotalEl.textContent = '0';
            return;
        }

        fetch(`{{ url('/admin/suppliers') }}/${supplierId}/produk-list?kategori_id=${kategoriId}`)
            .then(r => r.json())
            .then(renderProduk)
            .catch(() => {
                produkContainer.innerHTML = `<tr><td colspan="7" class="text-center p-4 text-red-600">Gagal memuat data.</td></tr>`;
            });
    }

    supplierSelect.addEventListener('change', loadProduk);
    kategoriFilter.addEventListener('change', loadProduk);
</script>