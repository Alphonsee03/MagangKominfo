document.addEventListener("DOMContentLoaded", () => {
    let currentPage = 1;
    let lastPage = 1;

    const tbody = document.getElementById("table-body");
    const pageInfo = document.getElementById("page-info");
    const prevBtn = document.getElementById("prev-page");
    const nextBtn = document.getElementById("next-page");

    const detailModal = document.getElementById("modal-detail");
    const detailBody = document.getElementById("detail-body");
    let invoiceUrl = null;

    // ✅ Export PDF (pindah ke luar loadData)
    document.getElementById("btn-export").addEventListener("click", () => {
        const start = document.getElementById("start_date").value;
        const end = document.getElementById("end_date").value;
        const metode = document.getElementById("metode").value;
        const search = document.getElementById("search").value;

        const params = new URLSearchParams({
            start_date: start,
            end_date: end,
            metode,
            search,
        });

        window.open(`/admin/transaksi/export/pdf?${params}`, "_blank");
    });

    async function loadData(page = 1) {
        const start = document.getElementById("start_date").value;
        const end = document.getElementById("end_date").value;
        const metode = document.getElementById("metode").value;
        const search = document.getElementById("search").value;

        const params = new URLSearchParams({
            page,
            start_date: start,
            end_date: end,
            metode,
            search,
        });

        const res = await fetch(`/admin/transaksi/data?${params}`);
        const json = await res.json();

        tbody.innerHTML = "";
        json.data.forEach((tr) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td class="p-2">${tr.created_at}</td>
                <td class="p-2 font-semibold">${tr.invoice}</td>
                <td class="p-2">${tr.user ? tr.user.nama : "-"}</td>
                <td class="p-2">${tr.pelanggan ? tr.pelanggan.nama : "Umum"}</td>
                <td class="p-2">Rp ${parseInt(tr.total).toLocaleString()}</td>
                <td class="p-2">Rp ${parseInt(tr.bayar).toLocaleString()}</td>
                <td class="p-2">${tr.metode_pembayaran}</td>
                <td class="p-2">
                    <button data-id="${tr.id}" 
                        class="detail-btn bg-blue-500 text-white px-2 py-1 rounded">
                        Detail
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });

        currentPage = json.current_page;
        lastPage = json.last_page;

        pageInfo.innerText = `Halaman ${currentPage} dari ${lastPage}`;
        prevBtn.disabled = currentPage <= 1;
        nextBtn.disabled = currentPage >= lastPage;
    }

    ["start_date", "end_date", "metode"].forEach((id) => {
        document.getElementById(id).addEventListener("change", () => {
            loadData(1);
        });
    });

    let searchTimeout;
    document.getElementById("search").addEventListener("input", (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadData(1);
        }, 500); // delay 0.5 detik setelah berhenti ngetik
    });

    // Pagination buttons
    prevBtn.addEventListener("click", () => {
        if (currentPage > 1) loadData(currentPage - 1);
    });

    nextBtn.addEventListener("click", () => {
        if (currentPage < lastPage) loadData(currentPage + 1);
    });

    // Delegasi event: detail transaksi
    document.addEventListener("click", async (e) => {
        if (e.target.classList.contains("detail-btn")) {
            const id = e.target.dataset.id;
            const res = await fetch(`/admin/transaksi/${id}/detail`);
            const data = await res.json();
            invoiceUrl = `/admin/transaksi/${id}/export-pdf`;

            detailBody.innerHTML = `
                <p><b>Invoice:</b> ${data.invoice}</p>
                <p><b>Tanggal:</b> ${data.tanggal}</p>
                <p><b>Kasir:</b> ${data.kasir}</p>
                <p><b>Pelanggan:</b> ${data.pelanggan}</p>
                <p><b>Metode:</b> ${data.metode}</p>
                <hr class="my-2">
                <table class="w-full text-sm border mt-2">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Produk</th>
                            <th class="p-2">Kode</th>
                            <th class="p-2">Qty</th>
                            <th class="p-2">Harga</th>
                            <th class="p-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.items
                            .map(
                                (it) => `
                            <tr>
                                <td class="p-2">${it.produk}</td>
                                <td class="p-2">${it.kode}</td>
                                <td class="p-2">${it.qty}</td>
                                <td class="p-2">Rp ${parseInt(
                                    it.harga
                                ).toLocaleString()}</td>
                                <td class="p-2">Rp ${parseInt(
                                    it.subtotal
                                ).toLocaleString()}</td>
                            </tr>
                        `
                            )
                            .join("")}
                    </tbody>
                </table>
                <div class="text-right mt-3 space-y-1">
                    <p><b>Total:</b> Rp ${parseInt(
                        data.total
                    ).toLocaleString()}</p>
                    <p><b>Diskon:</b> Rp ${parseInt(
                        data.diskon
                    ).toLocaleString()}</p>
                    <p><b>Total Bayar:</b> Rp ${parseInt(
                        data.total - data.diskon
                    ).toLocaleString()}</p>
                    <p><b>Bayar:</b> Rp ${parseInt(
                        data.bayar
                    ).toLocaleString()}</p>
                    <p><b>Kembali:</b> Rp ${parseInt(
                        data.kembali
                    ).toLocaleString()}</p>
                </div>


            `;

            detailModal.classList.remove("hidden");
            detailModal.classList.add("flex");
        }
    });

    document.getElementById("close-detail").addEventListener("click", () => {
        detailModal.classList.add("hidden");
        detailModal.classList.remove("flex");
    });

    document.getElementById("btn-print").addEventListener("click", () => {
        if (invoiceUrl) window.open(invoiceUrl, "_blank");
    });

    // Initial load
    loadData();
});
