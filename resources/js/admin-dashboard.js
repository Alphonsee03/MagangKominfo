import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", () => {
    const periodeEl = document.getElementById("periode");
    const tahunEl = document.getElementById("tahun");
    const loadingEl = document.getElementById("loading");

    const elTotalOmzet = document.getElementById("totalOmzet");
    const elTotalProfit = document.getElementById("totalProfit");
    const elTotalTransaksi = document.getElementById("totalTransaksi");
    const elTotalProduk = document.getElementById("totalProduk");
    const elTotalPembelian = document.getElementById("totalPembelian");

    const elProdukTerlaris = document.getElementById("produk-terlaris");
    const elSupplierTerbanyak = document.getElementById("supplier-terbanyak");
    const elTransaksiTertinggi = document.getElementById("transaksi-tertinggi");
    const elStokKritis = document.getElementById("stok-kritis");

    const ctx = document.getElementById("chart-bar").getContext("2d");
    let chart = null;

    function fmtRupiah(v) {
        if (v === null || v === undefined) return "Rp 0";
        const n = Number(v) || 0;
        return "Rp " + n.toLocaleString("id-ID", { maximumFractionDigits: 0 });
    }

    function showLoading(show = true) {
        loadingEl.classList.toggle("hidden", !show);
    }

    async function loadYears() {
        try {
            const res = await fetch("/admin/dashboard/years");
            if (!res.ok) throw new Error("Failed to fetch years");
            const years = await res.json();
            tahunEl.innerHTML = "";
            years.forEach((y) => {
                const opt = document.createElement("option");
                opt.value = y;
                opt.textContent = y;
                tahunEl.appendChild(opt);
            });
            const current = new Date().getFullYear();
            if (years.includes(current)) tahunEl.value = current;
            else if (years.length) tahunEl.value = years[0];
        } catch (err) {
            console.error("Gagal load years:", err);
        }
    }

    async function loadData() {
        showLoading(true);

        const periode = periodeEl.value;
        const tahun = tahunEl.value;

        const params = new URLSearchParams({ periode });
        // append tahun only for bulan or minggu (backend uses tahun for those),
        // backend handles 'tahun' period as group-by per year without tahun param.
        if ((periode === "bulan" || periode === "minggu") && tahun) {
            params.append("tahun", tahun);
        }

        try {
            const res = await fetch(
                `/admin/dashboard/data?${params.toString()}`
            );
            const data = await res.json();
            if (data.error) {
                console.error("Backend error:", data.message);
                showLoading(false);
                return;
            }

            // ensure tahun dropdown exists and populated for periode that need it
            if (periode === "bulan" || periode === "minggu") {
                tahunEl.classList.remove("hidden");
                if (!tahunEl.options.length) {
                    // try to use data.years if provided, otherwise call years endpoint
                    if (Array.isArray(data.years) && data.years.length) {
                        tahunEl.innerHTML = "";
                        data.years.forEach((y) => {
                            const opt = document.createElement("option");
                            opt.value = y;
                            opt.textContent = y;
                            tahunEl.appendChild(opt);
                        });
                    } else {
                        await loadYears();
                    }
                }
            } else {
                tahunEl.classList.add("hidden");
            }

            // Update cards
            elTotalOmzet.innerText = fmtRupiah(data.cards.total_omzet);
            elTotalProfit.innerText = fmtRupiah(data.cards.total_profit);
            elTotalTransaksi.innerText = Number(
                data.cards.total_transaksi || 0
            );
            elTotalProduk.innerText = Number(data.cards.total_produk || 0);
            elTotalPembelian.innerText = fmtRupiah(data.cards.total_pembelian);

            // Update chart
            const labels = Array.from(data.chart.labels || []);
            const omzet = Array.from(data.chart.omzet || []).map((n) =>
                Number(n || 0)
            );
            const profit = Array.from(data.chart.profit || []).map((n) =>
                Number(n || 0)
            );

            function setChartHeight() {
                const chartContainer =
                    document.getElementById("chart-container");
                chartContainer.style.height = "300px"; // fixed height
            }

            if (chart) chart.destroy();

            // Buat gradient untuk bar (Omzet)
            const gradientBar = ctx.createLinearGradient(0, 0, 0, 400);
            gradientBar.addColorStop(0, "rgba(13,148,136,0.9)"); // teal-600
            gradientBar.addColorStop(1, "rgba(2,132,199,0.9)"); // sky-600

            // Buat gradient untuk line (Profit) shadow
            const gradientLine = ctx.createLinearGradient(0, 0, 0, 400);
            gradientLine.addColorStop(0, "rgba(180,83,9,0.8)"); // amber-700
            gradientLine.addColorStop(1, "rgba(180,83,9,0)"); // transparan ke bawah
            setChartHeight(labels);

            chart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels,
                    datasets: [
                        {
                            label: "Profit",
                            data: profit,
                            type: "line",
                            borderColor: "rgba(180,83,9,1)", // amber-700
                            borderWidth: 3,
                            pointBackgroundColor: "white",
                            pointBorderColor: "rgba(180,83,9,1)",
                            pointRadius: 4,
                            fill: true,
                            backgroundColor: gradientLine, // efek shadow ke bawah
                            tension: 0.4,
                            yAxisID: "y",
                            order: 1, // <-- profit di atas
                        },
                        {
                            label: "Omzet",
                            data: omzet,
                            backgroundColor: gradientBar,
                            borderRadius: 8,
                            yAxisID: "y",
                            barPercentage: 0.6,
                            categoryPercentage: 0.9,
                            order: 2, // <-- bar di bawah
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    interaction: { mode: "index", intersect: false },
                    plugins: {
                        legend: {
                            position: "top",
                            labels: {
                                font: { family: "Inter, sans-serif", size: 13 },
                                color: "#374151", // gray-700
                            },
                        },
                        tooltip: {
                            backgroundColor: "rgba(17,24,39,0.9)", // gray-900 semi
                            titleFont: { size: 13 },
                            bodyFont: { size: 12 },
                            padding: 10,
                            cornerRadius: 8,
                        },
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: {
                                    size: 13,
                                    weight: "600",
                                    family: "Inter, sans-serif",
                                },
                                color: "#0f172a", // slate-900
                                callback: function (val, index) {
                                    return this.getLabelForValue(val); // label tetap sama
                                },
                            },
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: "rgba(203,213,225,0.3)",
                                drawBorder: false,
                            },
                            ticks: {
                                font: {
                                    size: 13,
                                    weight: "600",
                                    family: "Inter, sans-serif",
                                },
                                color: "#0369a1", // sky-700
                                callback: function (value) {
                                    return (
                                        "Rp " +
                                        Number(value).toLocaleString("id-ID")
                                    );
                                },
                            },
                        },
                    },
                },
            });

            // Fungsi untuk mengupdate progress circle berdasarkan data
            function updateProgressCircles() {
                // Contoh: Update progress circle berdasarkan data
                document
                    .querySelector('[data-progress="omzet"]')
                    .style.setProperty("--percentage", 70);
                document
                    .querySelector('[data-progress="profit"]')
                    .style.setProperty("--percentage", 85);
                document
                    .querySelector('[data-progress="transaksi"]')
                    .style.setProperty("--percentage", 60);
                document
                    .querySelector('[data-progress="produk"]')
                    .style.setProperty("--percentage", 45);
                document
                    .querySelector('[data-progress="pembelian"]')
                    .style.setProperty("--percentage", 30);
            }

            // Panggil fungsi saat data sudah dimuat
            document.addEventListener(
                "DOMContentLoaded",
                updateProgressCircles
            );

            // Produk terlaris
            elProdukTerlaris.innerHTML = "";
            (data.produk_terlaris || []).forEach((p, index) => {
                const li = document.createElement("li");
                li.className = "flex justify-between items-center py-2";
                li.innerHTML = `
            <div class="flex items-center">
                <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-800 text-xs flex items-center justify-center font-bold mr-3">${
                    index + 1
                }</span>
                <span class="font-medium text-slate-800">${p.nama}</span>
            </div>
            <span class="bg-purple-50 text-purple-800 text-xs font-semibold px-2 py-1 rounded-full">${
                p.jumlah
            }</span>
        `;
                elProdukTerlaris.appendChild(li);
            });

            // Supplier terbanyak
            elSupplierTerbanyak.innerHTML = "";
            (data.supplier_terbanyak || []).forEach((s, index) => {
                const li = document.createElement("li");
                li.className = "flex justify-between items-center py-2";
                li.innerHTML = `
            <div class="flex items-center">
                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-800 text-xs flex items-center justify-center font-bold mr-3">${
                    index + 1
                }</span>
                <span class="font-medium text-slate-800">${s.nama}</span>
            </div>
            <span class="bg-blue-50 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">${
                s.total
            }</span>
        `;
                elSupplierTerbanyak.appendChild(li);
            });

            // Transaksi tertinggi
            elTransaksiTertinggi.innerHTML = "";
            (data.transaksi_tertinggi || []).forEach((t) => {
                const tr = document.createElement("tr");
                tr.className = "py-3";
                tr.innerHTML = `
            <td class="py-3 font-medium text-slate-800">${t.invoice}</td>
            <td class="py-3 text-right">
                <span class="bg-green-50 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">${fmtRupiah(
                    t.total
                )}</span>
            </td>
        `;
                elTransaksiTertinggi.appendChild(tr);
            });

            // Stok kritis
            elStokKritis.innerHTML = "";
            (data.stok_kritis || []).forEach((s) => {
                const tr = document.createElement("tr");
                tr.className = "py-3";
                const isCritical = s.stok <= 2;
                const bgColor = isCritical
                    ? "bg-red-50 text-red-800"
                    : "bg-amber-50 text-amber-800";

                tr.innerHTML = `
            <td class="py-3 font-medium text-slate-800">${s.nama}</td>
            <td class="py-3 text-right">
                <span class="${bgColor} text-xs font-semibold px-2 py-1 rounded-full">${s.stok}</span>
            </td>
        `;
                elStokKritis.appendChild(tr);
            });
        } catch (err) {
            console.error(err);
        } finally {
            showLoading(false);
        }
    }

    // --- Make default periode = 'all' on initial load so page doesn't start at 'minggu' ---
    if (periodeEl) periodeEl.value = "all";
    if (tahunEl) tahunEl.classList.add("hidden"); // hide at start

    // event listeners
    periodeEl?.addEventListener("change", async () => {
        // if user selects bulan/minggu we want options loaded
        if (periodeEl.value === "bulan" || periodeEl.value === "minggu") {
            await loadYears();
        }
        await loadData();
    });
    tahunEl?.addEventListener("change", loadData);

    // initial: load years (so dropdown ready) then data (with periode=all)
    (async () => {
        await loadYears();
        await loadData();
    })();
});
