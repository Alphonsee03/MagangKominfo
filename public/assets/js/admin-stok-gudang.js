document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.getElementById("stok-body");
    const supplierSelect = document.getElementById("supplier_id");
    const btnExport = document.getElementById("btn-export");

    async function loadData() {
        const supplier_id = supplierSelect.value;
        const res = await fetch(`/admin/laporan/stok-gudang/data?supplier_id=${supplier_id}`);
        const data = await res.json();

        tbody.innerHTML = "";
        data.forEach((p, i) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td class="p-4 text-center text-gray-600 font-medium">${i + 1}</td>
                <td class="p-4 font-mono text-sm text-teal-700 font-semibold">${p.kode_produk}</td>
                <td class="p-4 text-gray-900 text-center">${p.nama}</td>
                <td class="p-4 text-center">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                        ${p.stok > 20 ? 'bg-green-100 text-green-800' : 
                        p.stok > 5 ? 'bg-amber-100 text-amber-800' : 
                        'bg-red-100 text-red-800'}">
                        ${p.stok} pcs
                    </span>
                </td>
                <td class="p-4 text-center font-mono text-sm text-gray-700">Rp ${parseInt(p.harga_beli).toLocaleString('id-ID')}</td>
                <td class="p-4 text-center font-mono text-sm text-gray-900 font-semibold">Rp ${parseInt(p.harga_jual).toLocaleString('id-ID')}</td>
                <td class="p-4 text-center font-mono text-sm text-blue-800 font-bold">Rp ${parseInt(p.nilai_stok).toLocaleString('id-ID')}</td>
                <td class="p-4 text-center font-mono text-sm text-gray-900 font-semibold">${p.suppliers || '-'}</td>
            `;
            tbody.appendChild(row);
        });
    }

    supplierSelect.addEventListener("change", loadData);

    btnExport.addEventListener("click", () => {
        const supplier_id = supplierSelect.value;
        window.open(`/admin/laporan/stok-gudang/export-pdf?supplier_id=${supplier_id}`, "_blank");
    });

    loadData();
});
