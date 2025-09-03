document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.getElementById("table-body");

    async function loadData() {
        const start = document.getElementById("start_date").value;
        const end = document.getElementById("end_date").value;
        const supplier_id = document.getElementById("supplier_id").value;

        const params = new URLSearchParams({ start_date: start, end_date: end, supplier_id });
        const res = await fetch(`/admin/laporan/pembelian/data?${params}`);
        const json = await res.json();

        tbody.innerHTML = "";
        json.data.forEach((row, i) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td class="p-2 border text-center">${i+1}</td>
                <td class="p-2 border">${row.tanggal}</td>
                <td class="p-2 border">${row.produk}</td>
                <td class="p-2 border">${row.kode}</td>
                <td class="p-2 border">${row.supplier}</td>
                <td class="p-2 border text-right">${row.jumlah}</td>
                <td class="p-2 border text-right">Rp ${parseInt(row.harga_beli).toLocaleString()}</td>
                <td class="p-2 border text-right">Rp ${parseInt(row.subtotal).toLocaleString()}</td>
                <td class="p-2 border">${row.keterangan ?? '-'}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    ["start_date", "end_date", "supplier_id"].forEach(id => {
        document.getElementById(id).addEventListener("change", () => loadData());
    });

    document.getElementById("btn-export").addEventListener("click", () => {
        const start = document.getElementById("start_date").value;
        const end = document.getElementById("end_date").value;
        const supplier_id = document.getElementById("supplier_id").value;

        const params = new URLSearchParams({ start_date: start, end_date: end, supplier_id });
        window.open(`/admin/laporan/pembelian/export-pdf?${params}`, "_blank");
    });

    // Initial load
    loadData();
});
