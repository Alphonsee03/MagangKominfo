
document.addEventListener("DOMContentLoaded", () => {
    async function loadData() {
        const start = document.getElementById("start_date").value;
        const end = document.getElementById("end_date").value;

        const params = new URLSearchParams({ start_date: start, end_date: end });
        const res = await fetch(`/admin/laporan/profit/data?${params}`);
        const json = await res.json();

        document.getElementById("total-penjualan").innerText = "Rp " + json.summary.total_penjualan.toLocaleString();
        document.getElementById("total-modal").innerText = "Rp " + json.summary.total_modal.toLocaleString();
        document.getElementById("total-profit").innerText = "Rp " + json.summary.profit.toLocaleString();
        document.getElementById("total-transaksi").innerText = json.summary.total_transaksi.toLocaleString() + " Transaksi";

        const tbody = document.getElementById("table-body");
        tbody.innerHTML = "";
        json.data.forEach(row => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td class="p-4 text-center font-mono text-sm text-teal-700 font-semibold">${row.invoice}</td>
                <td class="p-4 text-center text-gray-700">${row.tanggal}</td>
                <td class="p-4 text-center text-gray-800">${row.kasir}</td>
                <td class="p-4 text-center text-gray-900">${row.produk}</td>
                <td class="p-4 text-center">
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        ${row.qty} pcs
                    </span>
                </td>
                <td class="p-4 text-center font-mono text-sm text-gray-700">Rp ${row.harga_beli.toLocaleString('id-ID')}</td>
                <td class="p-4 text-center font-mono text-sm text-gray-900 font-semibold">Rp ${row.harga_jual.toLocaleString('id-ID')}</td>
                <td class="p-4 text-center font-mono text-sm text-blue-800 font-bold">Rp ${row.subtotal.toLocaleString('id-ID')}</td>
                <td class="p-4 text-center font-mono text-sm text-green-600 font-bold">
                    <span class="inline-flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Rp ${row.profit.toLocaleString('id-ID')}
                    </span>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    document.getElementById("btn-export").addEventListener("click", () => {
    const start = document.getElementById("start_date").value;
    const end = document.getElementById("end_date").value;

    const params = new URLSearchParams({ start_date: start, end_date: end });
    window.open(`/admin/laporan/profit/export-pdf?${params}`, "_blank");
});


    ["start_date", "end_date"].forEach(id => {
        document.getElementById(id).addEventListener("change", loadData);
    });

    loadData();
});
