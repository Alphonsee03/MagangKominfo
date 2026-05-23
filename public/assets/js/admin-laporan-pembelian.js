document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.getElementById("table-body");
    const emptyState = document.getElementById("empty-state");
    const totalItems = document.getElementById("total-items");
    const totalPembelian = document.getElementById("total-pembelian");
    const totalItem = document.getElementById("total-item");
    const totalNilai = document.getElementById("total-nilai");
    const rataHarga = document.getElementById("rata-harga");
    let sortBy = "created_at";
    let sortOrder = "desc";

    function updateSortIcons() {
        document.querySelectorAll(".sortable").forEach((th) => {
            const icon = th.querySelector("i");
            if (th.dataset.sort === sortBy) {
                icon.className = `fas fa-sort-${sortOrder === "asc" ? "up" : "down"} ml-1`;
            } else {
                icon.className = "fas fa-sort ml-1";
            }
        });
    }

    async function loadData() {
        const start = document.getElementById("start_date").value;
        const end = document.getElementById("end_date").value;
        const supplier_id = document.getElementById("supplier_id").value;

        const params = new URLSearchParams({ start_date: start, end_date: end, supplier_id, sort_by: sortBy, sort_order: sortOrder });
        
        try {
            const res = await fetch(`/admin/laporan/pembelian/data?${params}`);
            if (!res.ok) {
                throw new Error(`HTTP ${res.status}: ${res.statusText}`);
            }
            const json = await res.json();

            if (!json.data || !Array.isArray(json.data)) {
                throw new Error("Format response tidak valid: 'data' bukan array");
            }

            tbody.innerHTML = "";
            json.data.forEach((row, i) => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td class="p-1 text-center text-gray-900 font-medium">${sortOrder === 'desc' ? json.data.length - i : i + 1}</td>
                    <td class="p-4 text-center text-gray-700">${row.tanggal}</td>
                    <td class="p-4 text-center text-gray-900 font-medium">${row.produk}</td>
                    <td class="p-4 text-center font-mono text-sm text-teal-700">${row.kode}</td>
                    <td class="p-4 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            ${row.supplier}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            ${row.jumlah} pcs
                        </span>
                    </td>
                    <td class="p-4 text-center font-mono text-sm text-gray-700">Rp ${parseInt(row.harga_beli).toLocaleString('id-ID')}</td>
                    <td class="p-4 text-center font-mono text-sm text-blue-800 font-bold">Rp ${parseInt(row.subtotal).toLocaleString('id-ID')}</td>
                    <td class="p-4 text-center text-sm text-gray-600">${row.keterangan ?? '-'}</td>
                `;
                tbody.appendChild(tr);
            });

            // Empty state toggle
            if (emptyState) {
                emptyState.classList.toggle("hidden", json.data.length > 0);
            }

            // Summary update
            updateSortIcons();
            if (totalItems) totalItems.textContent = `${json.data.length} pembelian`;
            if (totalPembelian) totalPembelian.textContent = json.data.length;
            if (totalItem) totalItem.textContent = json.data.reduce((s, r) => s + parseInt(r.jumlah || 0), 0);
            if (totalNilai) {
                const total = json.data.reduce((s, r) => s + parseInt(r.subtotal || 0), 0);
                totalNilai.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }
            if (rataHarga) {
                const total = json.data.reduce((s, r) => s + parseInt(r.subtotal || 0), 0);
                const count = json.data.length;
                rataHarga.textContent = count > 0 ? `Rp ${Math.round(total / count).toLocaleString('id-ID')}` : 'Rp 0';
            }

        } catch (err) {
            console.error("Gagal load data pembelian:", err);
            tbody.innerHTML = `<tr><td colspan="9" class="p-4 text-center text-red-500">Gagal memuat data: ${err.message}</td></tr>`;
        }
    }

    // Sorting click handlers
    document.querySelectorAll(".sortable").forEach((th) => {
        th.addEventListener("click", () => {
            const col = th.dataset.sort;
            sortOrder = sortBy === col && sortOrder === "asc" ? "desc" : "asc";
            sortBy = col;
            loadData();
        });
    });

    ["start_date", "end_date", "supplier_id"].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener("change", () => loadData());
    });

    const btnExport = document.getElementById("btn-export");
    if (btnExport) {
        btnExport.addEventListener("click", () => {
            const start = document.getElementById("start_date").value;
            const end = document.getElementById("end_date").value;
            const supplier_id = document.getElementById("supplier_id").value;

            const params = new URLSearchParams({ start_date: start, end_date: end, supplier_id });
            window.open(`/admin/laporan/pembelian/export-pdf?${params}`, "_blank");
        });
    }

    // Initial load
    loadData();
});
