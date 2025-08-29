import { Chart, ArcElement, Tooltip, Legend, PieController } from "chart.js";
Chart.register(ArcElement, Tooltip, Legend, PieController);

document.addEventListener("DOMContentLoaded", () => {
    let metodeChart = null;

    async function loadRekap() {
        const res = await fetch("/kasir/transaksi/rekap/harian");
        const data = await res.json();

        document.getElementById("rekap-transaksi").innerText = data.jumlah_transaksi;
        document.getElementById("rekap-omzet").innerText = "Rp " + parseInt(data.omzet).toLocaleString();
        document.getElementById("rekap-bayar").innerText = "Rp " + parseInt(data.total_bayar).toLocaleString();
        document.getElementById("rekap-kembali").innerText = "Rp " + parseInt(data.total_kembali).toLocaleString();

        // render chart metode pembayaran
        const ctx = document.getElementById("rekap-metode");
        const metode = data.metode || {};
        const labels = Object.keys(metode);
        const values = Object.values(metode);

        if (metodeChart) metodeChart.destroy();

        metodeChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: labels,
                datasets: [
                    {
                        data: values,
                        backgroundColor: ["#10B981", "#3B82F6"],
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
