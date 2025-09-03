document.addEventListener("DOMContentLoaded", () => {
    let currentPage = 1;
    const bodyStok = document.getElementById("stok-body");
    const pageInfo = document.getElementById("page-info");

    const searchInput = document.getElementById("search");
    const supplierSelect = document.getElementById("filter-supplier");

    async function loadData(page = 1) {
        const search = searchInput.value;
        const supplier_id = supplierSelect.value;

        const params = new URLSearchParams({
            page,
            search,
            supplier_id,
        });

        const res = await fetch(`/kasir/stok/data?${params.toString()}`);
        const json = await res.json();

        // isi tabel
        bodyStok.innerHTML = "";
        json.data.forEach((p) => {
            const row = document.createElement("tr");
            row.classList.add("border-b", "hover:bg-gray-50");
            row.innerHTML = `
                <td class="p-4 font-mono text-sm font-semibold text-teal-700 text-center">${p.kode_produk}</td>
                <td class="p-4 text-gray-900 font-medium text-center">${p.nama}</td>
                <td class="p-4 text-center">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        ${p.stok > 20 ? 'bg-green-100 text-green-800' : 
                        p.stok > 5 ? 'bg-amber-100 text-amber-800' : 
                        'bg-red-100 text-red-800'}">
                        ${p.stok} pcs
                    </span>
                </td>
                <td class="p-4  font-mono text-gray-900 text-center">
                    Rp ${parseInt(p.harga_jual).toLocaleString('id-ID')}
                </td>
                <td class="p-4 text-center">
                    <div class="flex flex-wrap justify-center gap-1">
                        ${p.suppliers && p.suppliers.length > 0 ? 
                            p.suppliers.map(supplier => `
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    ${supplier}
                                </span>
                            `).join('') : 
                            '<span class="text-gray-400 text-sm">-</span>'
                        }
                    </div>
                </td>
            `;
            bodyStok.appendChild(row);
        });

        // update pagination
        pageInfo.innerText = `Halaman ${json.current_page} dari ${json.last_page}`;
        currentPage = json.current_page;

        // disable prev/next kalau mentok
        document.getElementById("prev-page").disabled = currentPage <= 1;
        document.getElementById("next-page").disabled =
            currentPage >= json.last_page;
    }

    // pagination
    document.getElementById("prev-page").addEventListener("click", () => {
        if (currentPage > 1) loadData(currentPage - 1);
    });
    document.getElementById("next-page").addEventListener("click", () => {
        loadData(currentPage + 1);
    });

    // search realtime (debounce)
    let searchTimeout;
    searchInput.addEventListener("input", () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => loadData(1), 400);
    });

    // filter supplier
    supplierSelect.addEventListener("change", () => loadData(1));

    // initial load
    loadData();
});
