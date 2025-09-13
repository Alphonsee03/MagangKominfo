document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    const addProductBtn = document.querySelector("#add-product");
    const produkWrapper = document.getElementById("produk-wrapper");

    // Urutan field per produk
    const focusable = [
        "kode_produk",
        "nama",
        "kategori_id",
        "harga_beli",
        "harga_jual",
        "stok",
        "suppliers", // di DOM bisa bernama suppliers[]
        "deskripsi",
    ];

    // Helper: cari elemen field dengan fallback [] (contoh suppliers[])
    function getFieldEl(prodIndex, key) {
        const base = `products[${prodIndex}][${key}]`;
        // coba nama tanpa [] dulu
        let el = form.querySelector(`[name="${base}"]`);
        if (el) return el;
        // kalau tidak ketemu, coba versi array []
        el = form.querySelector(`[name="${base}[]"]`);
        return el || null;
    }

    // Fokus field tertentu
    function focusInput(prodIndex, fieldIndex) {
        const el = getFieldEl(prodIndex, focusable[fieldIndex]);
        if (el) el.focus();
    }

    // Fokus awal
    focusInput(0, 0);

    // Navigasi Enter / Esc / Shift+I
    form.addEventListener("keydown", (e) => {
        const targetName = e.target.getAttribute("name");
        if (!targetName) return;

        // Match nama products[x][field] atau products[x][field][]
        const m = targetName.match(/products\[(\d+)\]\[([^\]]+)\](\[\])?/);
        if (!m) {
            // Bukan field produk, abaikan
            return;
        }

        const prodIndex = parseInt(m[1], 10);
        // Normalisasi fieldKey (buang [] kalau ada)
        let fieldKey = m[2];

        // ENTER → next
        if (e.key === "Enter") {
            const fieldIndex = focusable.indexOf(fieldKey);
            if (fieldIndex === -1) return;

            // Kalau bukan field terakhir
            if (fieldIndex < focusable.length - 1) {
                e.preventDefault();

                // Khusus supplier: Enter = loncat ke deskripsi
                if (fieldKey === "suppliers") {
                    focusInput(prodIndex, focusable.indexOf("deskripsi"));
                } else {
                    // default: pindah ke field berikutnya
                    focusInput(prodIndex, fieldIndex + 1);
                }
            } else {
                // Field terakhir (deskripsi) → submit atau ke card berikutnya
                e.preventDefault();
                const nextKode = getFieldEl(prodIndex + 1, "kode_produk");
                if (nextKode) {
                    focusInput(prodIndex + 1, 0);
                } else {
                    form.submit();
                }
            }
        }

        // ESC → reset semua & fokus awal
        if (e.key === "Escape") {
            e.preventDefault();
            form.reset();
            focusInput(0, 0);
        }

        // Shift + I → tambah card baru
        if (e.shiftKey && e.key.toLowerCase() === "i") {
            e.preventDefault();
            if (addProductBtn) {
                addProductBtn.classList.remove("hidden");
                addProductBtn.click();
                // Fokus ke kode_produk di card baru (productIndex sudah di-increment di handler click)
                setTimeout(() => {
                    const totalCards = countCards(); // berapa card saat ini
                    const newIndex = totalCards - 1; // index card terakhir
                    focusInput(newIndex, 0);
                }, 0);
            }
        }
    });

    // ===== Clone card (pakai punyamu, tapi sedikit diperkuat reset select) =====
    let productIndex = 1;
    document
        .getElementById("add-product")
        .addEventListener("click", function () {
            const wrapper = produkWrapper;
            const newItem = wrapper.firstElementChild.cloneNode(true);

            newItem.classList.add("mt-6");
            // Reset input/textarea/select & update name index
            newItem
                .querySelectorAll("input, textarea, select")
                .forEach((el) => {
                    // Update index di name: products[0] -> products[productIndex]
                    const name = el.getAttribute("name");
                    if (name) {
                        el.setAttribute(
                            "name",
                            name.replace(/\[\d+\]/, `[${productIndex}]`)
                        );
                    }

                    // Reset nilai
                    if (el.tagName === "SELECT") {
                        // clear selected (terutama multiple)
                        Array.from(el.options).forEach(
                            (opt) => (opt.selected = false)
                        );
                        el.selectedIndex = -1;
                    } else if (el.type === "file") {
                        el.value = "";
                    } else {
                        el.value = "";
                    }
                });

            wrapper.appendChild(newItem);
            productIndex++;
        });

    // Hitung card berdasarkan field kode_produk yang ada
    function countCards() {
        return form.querySelectorAll(
            `[name^="products["][name$="[kode_produk]"]`
        ).length;
    }
});
