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
                <td class="p-4 text-center font-bold text-gray-700">${dayjs(tr.created_at).format('DD/MM/YYYY HH:mm')}</td>
                <td class="p-4 text-center font-mono text-teal-700 font-semibold">${tr.invoice}</td>
                <td class="p-4 text-center text-gray-800">${tr.user ? tr.user.nama : "-"}</td>
                <td class="p-4 text-center text-gray-800">${tr.pelanggan ? tr.pelanggan.nama : "Umum"}</td>
                <td class="p-4 text-center font-mono text-gray-900">Rp ${parseInt(tr.total).toLocaleString('id-ID')}</td>
                <td class="p-4 text-center font-mono text-green-600 font-semibold">Rp ${parseInt(tr.bayar).toLocaleString('id-ID')}</td>
                <td class="p-4 text-center">
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium 
                        ${tr.metode_pembayaran === 'cash' ? 'bg-green-100 text-green-800' : 
                        tr.metode_pembayaran === 'qris' ? 'bg-purple-100 text-purple-800' : 
                        'bg-blue-100 text-blue-800'}">
                        ${tr.metode_pembayaran}
                    </span>
                </td>
                <td class="p-4 text-center">
                    <button data-id="${tr.id}" 
                        class="detail-btn bg-teal-600 text-white px-3 py-1.5 rounded-lg hover:bg-teal-700 transition-colors text-xs">
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-teal-50 p-4 rounded-lg border border-teal-100">
                    <h4 class="font-semibold text-teal-800 mb-3">Informasi Transaksi</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-teal-600">Invoice:</span><span class="font-semibold">${data.invoice}</span></div>
                        <div class="flex justify-between"><span class="text-teal-600">Tanggal:</span><span>${data.tanggal}</span></div>
                        <div class="flex justify-between"><span class="text-teal-600">Kasir:</span><span>${data.kasir}</span></div>
                        <div class="flex justify-between"><span class="text-teal-600">Pelanggan:</span><span>${data.pelanggan}</span></div>
                        <div class="flex justify-between"><span class="text-teal-600">Metode:</span><span class="px-2 py-1 rounded-full text-xs font-medium ${data.metode === 'cash' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800'}">${data.metode}</span></div>
                    </div>
                </div>

                <div class="bg-teal-50 p-4 rounded-lg border border-teal-100">
                    <h4 class="font-semibold text-teal-800 mb-3">Informasi Pembayaran</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-teal-600">Total:</span><span class="font-semibold">Rp ${parseInt(data.total).toLocaleString('id-ID')}</span></div>
                        <div class="flex justify-between"><span class="text-teal-600">Diskon:</span><span class="text-amber-600">Rp ${parseInt(data.diskon).toLocaleString('id-ID')}</span></div>
                        <div class="flex justify-between"><span class="text-teal-600">Total Bayar:</span><span class="font-semibold text-green-600">Rp ${parseInt(data.total - data.diskon).toLocaleString('id-ID')}</span></div>
                        <div class="flex justify-between"><span class="text-teal-600">Bayar:</span><span class="font-semibold text-green-600">Rp ${parseInt(data.bayar).toLocaleString('id-ID')}</span></div>
                        <div class="flex justify-between"><span class="text-teal-600">Kembali:</span><span class="text-blue-600">Rp ${parseInt(data.kembali).toLocaleString('id-ID')}</span></div>
                    </div>
                </div>
            </div>

            <div class="border border-teal-200 rounded-lg overflow-hidden">
                <h4 class="font-semibold text-teal-800 p-4 bg-teal-50">Daftar Produk</h4>
                <table class="w-full text-sm">
                    <thead class="bg-teal-100 text-teal-800">
                        <tr>
                            <th class="p-3 text-left">Produk</th>
                            <th class="p-3 text-left">Kode</th>
                            <th class="p-3 text-center">Qty</th>
                            <th class="p-3 text-right">Harga</th>
                            <th class="p-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-teal-50">
                        ${data.items.map((it) => `
                            <tr class="hover:bg-teal-50">
                                <td class="p-3">${it.produk}</td>
                                <td class="p-3 font-mono text-teal-700">${it.kode}</td>
                                <td class="p-3 text-center">${it.qty}</td>
                                <td class="p-3 text-right font-mono">Rp ${parseInt(it.harga).toLocaleString('id-ID')}</td>
                                <td class="p-3 text-right font-mono font-semibold">Rp ${parseInt(it.subtotal).toLocaleString('id-ID')}</td>
                            </tr>
                        `).join("")}
                    </tbody>
                </table>
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
