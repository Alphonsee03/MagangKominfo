//POS SCRIPT
document.addEventListener("DOMContentLoaded", () => {
    const kodeInput = document.getElementById("kode_produk");
    const qtyInput = document.getElementById("qty");
    const btnAdd = document.getElementById("btn-add");
    const cartBody = document.getElementById("cart-body");
    const cartTotal = document.getElementById("cart-total");
    const btnReset = document.getElementById("btn-reset");
    const btnBayar = document.getElementById("btn-bayar");
    const modalBayar = document.getElementById("modal-bayar");
    const btnClose = document.getElementById("btn-close");
    const formBayar = document.getElementById("form-bayar");

    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    // Render cart
    function loadCart() {
        fetch("/kasir/cart")
            .then((res) => {
                if (!res.ok) {
                    return res.text().then((text) => {
                        throw new Error(text);
                    });
                }
                return res.json();
            })
            .then((data) => {
                cartBody.innerHTML = "";
                Object.values(data.cart).forEach((item) => {
                    cartBody.innerHTML += `
                        <tr class="border-b cart-item-row hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-3 px-4 font-mono text-sm text-gray-700">${item.kode}</td>
                        <td class="py-3 px-4 font-bold text-slate-800">${item.nama}</td>
                        <td class="py-3 px-4 text-center">
                            <input type="number" value="${item.qty}" min="1" 
                                class="w-20 border border-gray-300 rounded-lg py-1.5 px-3 text-center focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                onchange="updateQty(${item.produk_id}, this.value)">
                        </td>
                        <td class="py-3 px-4 text-right font-medium text-gray-900">${item.harga}</td>
                        <td class="py-3 px-4 text-right font-semibold text-indigo-600">${item.subtotal}</td>
                        <td class="py-3 px-4 text-center">
                            <button onclick="removeItem(${item.produk_id})" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-full transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </td>
                    </tr>`;
                });
                cartTotal.innerText = data.total;
            });
    }

    // Add item
    btnAdd.addEventListener("click", () => {
        fetch("/kasir/cart/add", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrf,
                "X-Requested-With": "XMLHttpRequest",
            },
            body: JSON.stringify({
                kode_produk: kodeInput.value,
                qty: qtyInput.value,
            }),
        })
            .then((res) => res.json())
            .then(() => {
                kodeInput.value = "";
                qtyInput.value = 1;
                loadCart();
            });
    });

    // Reset cart
    btnReset.addEventListener("click", () => {
        fetch("/kasir/cart/reset", {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": csrf,
            },
        }).then(() => loadCart());
    });

    // Bayar modal
    btnBayar.addEventListener("click", () =>
        modalBayar.classList.remove("hidden")
    );
    btnClose.addEventListener("click", () =>
        modalBayar.classList.add("hidden")
    );

    // Proses bayar
    formBayar.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(formBayar);

        try {
            const res = await fetch("/kasir/checkout", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    Accept: "application/json", // minta Laravel mengembalikan JSON saat validasi gagal
                },
                body: formData,
            });

            // baca body sebagai text dulu, lalu parse JSON aman
            const text = await res.text();
            let data = {};
            try {
                data = text ? JSON.parse(text) : {};
            } catch (err) {
                console.error("Invalid JSON response", text);
                alert("Terjadi respon tidak terduga dari server. Cek log.");
                return;
            }

            if (!res.ok) {
                // res.ok false (400/422/500). Berikan pesan yang jelas.
                const message =
                    data.error || data.message || "Transaksi tidak berhasil";
                alert(message);
                // jangan tutup modal, jangan reset cart
                return;
            }

            // OK (200)
            if (data.invoice_url) {
                window.open(data.invoice_url, "_blank");
            }
            alert("Transaksi berhasil! Invoice: " + (data.invoice ?? "-"));
            modalBayar.classList.add("hidden");
            loadCart();
        } catch (err) {
            console.error("Fetch error", err);
            alert("Terjadi kesalahan koneksi / server. Silakan coba lagi.");
        }
    });

    // Initial load
    loadCart();

    // Global functions (expose to window)
    window.updateQty = (id, qty) => {
        fetch(`/kasir/cart/update/${id}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrf,
            },
            body: JSON.stringify({
                qty,
            }),
        }).then(() => loadCart());
    };

    window.removeItem = (id) => {
        fetch(`/kasir/cart/remove/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": csrf,
            },
        }).then(() => loadCart());
    };
});
