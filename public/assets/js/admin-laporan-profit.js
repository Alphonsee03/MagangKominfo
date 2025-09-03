
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

        const tbody = document.getElementById("table-body");
        tbody.innerHTML = "";
        json.data.forEach(row => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td class="p-2">${row.invoice}</td>
                <td class="p-2">${row.tanggal}</td>
                <td class="p-2">${row.kasir}</td>
                <td class="p-2">${row.produk}</td>
                <td class="p-2">${row.qty}</td>
                <td class="p-2">Rp ${row.harga_beli.toLocaleString()}</td>
                <td class="p-2">Rp ${row.harga_jual.toLocaleString()}</td>
                <td class="p-2">Rp ${row.subtotal.toLocaleString()}</td>
                <td class="p-2 text-green-600">Rp ${row.profit.toLocaleString()}</td>
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
