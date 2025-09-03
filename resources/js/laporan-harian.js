import { Chart, ArcElement, Tooltip, Legend, PieController } from "chart.js";
Chart.register(ArcElement, Tooltip, Legend, PieController);

document.addEventListener("DOMContentLoaded", () => {
    let metodeChart = null;

    async function loadRekap() {
        const res = await fetch("/kasir/transaksi/rekap/harian");
        const data = await res.json();

        document.getElementById("rekap-transaksi").innerText =
            data.jumlah_transaksi;
        document.getElementById("rekap-omzet").innerText =
            "Rp " + parseInt(data.omzet).toLocaleString();
        document.getElementById("rekap-bayar").innerText =
            "Rp " + parseInt(data.total_bayar).toLocaleString();
        document.getElementById("rekap-kembali").innerText =
            "Rp " + parseInt(data.total_kembali).toLocaleString();
        document.getElementById("rekap-item").innerText =
            parseInt(data.total_item).toLocaleString() + " pcs";

        // render chart metode pembayaran
        const ctx = document.getElementById("rekap-metode");
        const metode = data.metode || {};
        const labels = Object.keys(metode);
        const values = Object.values(metode);

        const tableBody = document.getElementById("produk-terlaris-table");
        tableBody.innerHTML = "";

        if (data.produk_terlaris && data.produk_terlaris.length > 0) {
            data.produk_terlaris.forEach((p, index) => {
                const row = document.createElement("tr");
                row.className = index % 2 === 0 ? "bg-rose-800/10" : "";

                const cellProduk = document.createElement("td");
                cellProduk.className = "py-2 truncate max-w-[100px]";
                cellProduk.textContent = p.produk;

                const cellQty = document.createElement("td");
                cellQty.className = "py-2 text-right font-bold";
                cellQty.textContent = `${p.qty} pcs`;

                row.appendChild(cellProduk);
                row.appendChild(cellQty);
                tableBody.appendChild(row);
            });
        } else {
            const row = document.createElement("tr");
            const cell = document.createElement("td");
            cell.colSpan = 2;
            cell.className = "text-center py-3 text-rose-200/80";
            cell.textContent = "Tidak ada data";
            row.appendChild(cell);
            tableBody.appendChild(row);
        }

        const tableBodyy = document.getElementById("waktu-transaksi-table");
        tableBodyy.innerHTML = "";

        if (data.waktu_terakhir && data.waktu_terakhir.length > 0) {
            tableBodyy.innerHTML = data.waktu_terakhir
                .map((transaction, index) => {
                    const time = transaction.split(" - ");
                    return `
            <tr class="${index % 2 === 0 ? "bg-violet-400 rounded-lg" : ""}">
                <td class="py-2 text-center text-sm font-mono">${time}</td>
                <td class="py-2 text-right font-bold"></td>
            </tr>
        `;
                })
                .join("");
        } else {
            tableBodyy.innerHTML =
                '<tr><td colspan="2" class="text-center py-3 text-violet-200/80">Tidak ada data</td></tr>';
        }

        if (metodeChart) metodeChart.destroy();

        metodeChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: labels,
                datasets: [
                    {
                        data: values,
                        backgroundColor: ["#1C05B3", "#EC008C"],
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: "bottom" },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `${context.label}: ${context.raw} transaksi`;
                            },
                        },
                    },
                },
            },
        });
    }

    loadRekap();
});
