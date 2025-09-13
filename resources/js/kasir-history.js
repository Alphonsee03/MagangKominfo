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
                <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                    ${dayjs(tr.created_at).tz("Asia/Jakarta").format("DD/MM/YYYY HH:mm")}
                </td>
                <td class="p-3 font-mono text-sm font-semibold text-teal-600">${tr.invoice}</td>
                <td class="p-3 text-sm text-gray-800">${tr.pelanggan ? tr.pelanggan.nama : "Umum"}</td>
                <td class="p-3 text-sm text-right font-medium text-gray-900">Rp ${parseInt(tr.total).toLocaleString()}</td>
                <td class="p-3 text-sm text-right text-gray-600">Rp ${parseInt(tr.diskon || 0).toLocaleString()}</td>
                <td class="p-3 text-sm text-right font-medium text-green-600">Rp ${parseInt(tr.bayar).toLocaleString()}</td>
                <td class="p-3 text-sm text-right font-medium text-red-600">Rp ${parseInt(tr.kembali).toLocaleString()}</td>
                <td class="p-3 text-sm text-center">
                    <span class="px-2.5 py-1 text-xs font-medium rounded-full ${tr.metode_pembayaran === 'cash' ? 'bg-green-100 text-green-800' : tr.metode_pembayaran === 'qris' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'}">
                        ${tr.metode_pembayaran}
                    </span>
                </td>
                <td class="p-3 text-sm text-gray-700">${tr.user ? tr.user.nama : "-"}</td>
                <td class="p-3 text-sm text-center">
                    <button class="detail-btn px-3 py-1.5 bg-teal-500 hover:bg-teal-600 text-white text-xs rounded-lg transition-colors flex items-center justify-center" data-id="${tr.id}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Detail
                    </button>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Informasi Transaksi -->
                    <div class="bg-teal-50 p-4 rounded-lg border border-teal-100">
                        <h4 class="font-semibold text-teal-800 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Informasi Transaksi
                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-teal-600 font-medium">Invoice:</span>
                                <span class="font-mono text-teal-800">${data.invoice}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-teal-600 font-medium">Tanggal:</span>
                                <span>${data.tanggal}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-teal-600 font-medium">Kasir:</span>
                                <span>${data.kasir}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-teal-600 font-medium">Pelanggan:</span>
                                <span>${data.pelanggan}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pembayaran -->
                    <div class="bg-teal-50 p-4 rounded-lg border border-teal-100">
                        <h4 class="font-semibold text-teal-800 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Informasi Pembayaran
                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-teal-600 font-medium">Total:</span>
                                <span class="font-medium text-teal-800">Rp ${parseInt(data.total).toLocaleString()}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-teal-600 font-medium">Diskon:</span>
                                <span class="text-amber-600">Rp ${parseInt(data.diskon || 0).toLocaleString()}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-emerald-600 font-medium">Total Pembayaran:</span>
                                <span class="text-emerald-600">Rp ${parseInt(data.total - data.diskon || 0).toLocaleString()}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-teal-600 font-medium">Bayar:</span>
                                <span class="text-green-600 font-medium">Rp ${parseInt(data.bayar).toLocaleString()}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-teal-600 font-medium">Kembali:</span>
                                <span class="text-blue-600">Rp ${parseInt(data.kembali).toLocaleString()}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Produk -->
                <div>
                    <h4 class="font-semibold text-teal-800 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Daftar Produk
                    </h4>
                    <div class="border border-teal-100 rounded-lg overflow-hidden">
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
                                    <tr class="hover:bg-teal-50 transition-colors">
                                        <td class="p-3">${it.produk}</td>
                                        <td class="p-3 font-mono text-teal-700">${it.kode}</td>
                                        <td class="p-3 text-center">${it.qty}</td>
                                        <td class="p-3 text-right">Rp ${parseInt(it.harga).toLocaleString()}</td>
                                        <td class="p-3 text-right font-medium text-teal-800">Rp ${parseInt(it.subtotal).toLocaleString()}</td>
                                    </tr>
                                `).join("")}
                            </tbody>
                        </table>
                    </div>
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
