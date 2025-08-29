document.addEventListener("DOMContentLoaded", () => {
    let currentPage = 1;
    const bodyRiwayat = document.getElementById("riwayat-body");
    const pageInfo = document.getElementById("page-info");
    const modal = document.getElementById("modal-detail");
    const detailBody = document.getElementById("detail-body");
    const btnPrint = document.getElementById("btn-print");
    let invoiceUrl = null;

    async function loadRiwayat(page = 1) {
        const res = await fetch(`/kasir/transaksi/history/data?page=${page}`);
        const json = await res.json();

        bodyRiwayat.innerHTML = "";
        json.data.forEach((tr) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td class="p-2">${tr.created_at}</td>
                <td class="p-2 font-semibold">${tr.invoice}</td>
                <td class="p-2">${tr.pelanggan ? tr.pelanggan.nama : "Umum"}</td>
                <td class="p-2">Rp ${parseInt(tr.total).toLocaleString()}</td>
                <td class="p-2">Rp ${parseInt(tr.diskon || 0).toLocaleString()}</td>
                <td class="p-2">Rp ${parseInt(tr.bayar).toLocaleString()}</td>
                <td class="p-2">Rp ${parseInt(tr.kembali).toLocaleString()}</td>
                <td class="p-2">${tr.metode_pembayaran}</td>
                <td class="p-2">${tr.user ? tr.user.nama : "-"}</td>
                <td class="p-2">
                    <button class="px-2 py-1 bg-blue-500 text-white rounded detail-btn" data-id="${tr.id}">Detail</button>
                </td>
            `;
            bodyRiwayat.appendChild(row);
        });

        pageInfo.innerText = `Halaman ${json.pagination.current_page} dari ${json.pagination.last_page}`;
        currentPage = json.pagination.current_page;
    }

    // pagination
    document.getElementById("prev-page").addEventListener("click", () => {
        if (currentPage > 1) loadRiwayat(currentPage - 1);
    });
    document.getElementById("next-page").addEventListener("click", () => {
        loadRiwayat(currentPage + 1);
    });

    // detail transaksi
    document.addEventListener("click", async (e) => {
        if (e.target.classList.contains("detail-btn")) {
            const id = e.target.dataset.id;
            const res = await fetch(`/kasir/transaksi/${id}/detail`);
            const data = await res.json();

            invoiceUrl = data.invoice_url;
            detailBody.innerHTML = `
                <div>
                    <p><b>Invoice:</b> ${data.invoice}</p>
                    <p><b>Tanggal:</b> ${data.tanggal}</p>
                    <p><b>Kasir:</b> ${data.kasir}</p>
                    <p><b>Pelanggan:</b> ${data.pelanggan}</p>
                </div>
                <table class="w-full mt-4 text-sm border">
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
                        ${data.items.map((it) => `
                            <tr>
                                <td class="p-2">${it.produk}</td>
                                <td class="p-2">${it.kode}</td>
                                <td class="p-2">${it.qty}</td>
                                <td class="p-2">Rp ${parseInt(it.harga).toLocaleString()}</td>
                                <td class="p-2">Rp ${parseInt(it.subtotal).toLocaleString()}</td>
                            </tr>
                        `).join("")}
                    </tbody>
                </table>
                <div class="mt-4 text-right space-y-1">
                    <p>Total: Rp ${parseInt(data.total).toLocaleString()}</p>
                    <p>Diskon: Rp ${parseInt(data.diskon || 0).toLocaleString()}</p>
                    <p>Bayar: Rp ${parseInt(data.bayar).toLocaleString()}</p>
                    <p>Kembali: Rp ${parseInt(data.kembali).toLocaleString()}</p>
                </div>
            `;

            modal.classList.remove("hidden");
            modal.classList.add("flex");
        }
    });

    // cetak ulang invoice
    btnPrint.addEventListener("click", () => {
        if (invoiceUrl) window.open(invoiceUrl, "_blank");
    });

    document.getElementById("close-detail").addEventListener("click", () => {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    });

    loadRiwayat();
});
