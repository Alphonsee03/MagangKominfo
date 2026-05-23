
document.addEventListener("DOMContentLoaded", () => {
    let sortBy = "id";
    let sortOrder = "asc";

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

        const params = new URLSearchParams({ start_date: start, end_date: end, sort_by: sortBy, sort_order: sortOrder });
        
        try {
            const res = await fetch(`/admin/laporan/profit/data?${params}`);
            if (!res.ok) throw new Error(`HTTP ${res.status}: ${res.statusText}`);
            const json = await res.json();

            document.getElementById("total-penjualan").innerText = "Rp " + (json.summary.total_penjualan || 0).toLocaleString();
            document.getElementById("total-modal").innerText = "Rp " + (json.summary.total_modal || 0).toLocaleString();
            document.getElementById("total-profit").innerText = "Rp " + (json.summary.profit || 0).toLocaleString();
            document.getElementById("total-transaksi").innerText = (json.summary.total_transaksi || 0).toLocaleString() + " Transaksi";

            const tbody = document.getElementById("table-body");
            const emptyState = document.getElementById("empty-state");
            tbody.innerHTML = "";

            if (emptyState) emptyState.classList.toggle("hidden", json.data.length > 0);

            json.data.forEach((row, i) => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td class="p-4 text-center text-gray-600 font-medium">${sortOrder === 'desc' ? json.data.length - i : i + 1}</td>
                    <td class="p-4 text-center font-mono text-sm text-teal-700 font-semibold">${row.invoice}</td>
                    <td class="p-4 text-center text-gray-700">${row.tanggal}</td>
                    <td class="p-4 text-center text-gray-800">${row.kasir}</td>
                    <td class="p-4 text-center text-gray-900">${row.produk}</td>
                    <td class="p-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            ${row.qty} pcs
                        </span>
                    </td>
                    <td class="p-4 text-center font-mono text-sm text-gray-700">Rp ${(row.harga_beli || 0).toLocaleString('id-ID')}</td>
                    <td class="p-4 text-center font-mono text-sm text-gray-900 font-semibold">Rp ${(row.harga_jual || 0).toLocaleString('id-ID')}</td>
                    <td class="p-4 text-center font-mono text-sm text-blue-800 font-bold">Rp ${(row.subtotal || 0).toLocaleString('id-ID')}</td>
                    <td class="p-4 text-center font-mono text-sm text-green-600 font-bold">
                        <span class="inline-flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            Rp ${(row.profit || 0).toLocaleString('id-ID')}
                        </span>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            updateSortIcons();
        } catch (err) {
            console.error("Gagal load data profit:", err);
            document.getElementById("table-body").innerHTML = `<tr><td colspan="10" class="p-4 text-center text-red-500">Gagal memuat data: ${err.message}</td></tr>`;
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

    document.getElementById("btn-export").addEventListener("click", () => {
        const start = document.getElementById("start_date").value;
        const end = document.getElementById("end_date").value;

        const params = new URLSearchParams({ start_date: start, end_date: end });
        window.open(`/admin/laporan/profit/export-pdf?${params}`, "_blank");
    });

    ["start_date", "end_date"].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener("change", loadData);
    });

    loadData();
});
