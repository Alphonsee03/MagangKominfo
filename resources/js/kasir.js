//POS SCRIPT
document.addEventListener("DOMContentLoaded", () => {
    const kodeInput = document.getElementById("kode_produk");
    const qtyInput = document.getElementById("qty");
    const btnAdd = document.getElementById("btn-add");
    const cartBody = document.getElementById("cart-body");
    const cartTotal = document.getElementById("cart-total");
    const cartTotalBayar = document.getElementById("cart-total-bayar");
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
                        <tr class="border-b cart-item-row hover:bg-slate-600 transition-colors duration-200">
                        <td class="py-5 px-6 font-mono text-md text-center text-gray-700">${item.kode}</td>
                        <td class="py-5 px-6 font-bold text-md text-center text-slate-800">${item.nama}</td>
                        <td class="py-5 px-6 text-center text-md font-semibold">
                            <input type="number" value="${item.qty}" min="1" 
                                class="w-20 border border-gray-300 rounded-lg py-1.5 px-3 text-center focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                onchange="updateQty(${item.produk_id}, this.value)">
                        </td>
                        <td class="py-5 px-6 text-center text-md font-medium text-gray-900">${item.harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.').replace(/\.00$/, '')}</td>
                        <td class="py-5 px-6 text-center text-md font-semibold text-indigo-600">${item.subtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')}</td>
                        <td class="py-5 px-6 text-center">
                            <button onclick="removeItem(${item.produk_id})" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-full transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </td>
                    </tr>`;
                });
                cartTotal.innerText = data.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                cartTotalBayar.innerText = data.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
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

    const posContainer = document.getElementById("pos-container");

    if (posContainer) {
        const modalBayar = document.getElementById("modal-bayar");
        const isModalOpen = () =>
            modalBayar && !modalBayar.classList.contains("hidden");

        document.addEventListener("keydown", function (e) {
    const active = document.activeElement;

    // SHIFT+I → fokus ke input kode
    if (e.key.toLowerCase() === "i" && e.shiftKey) {
        e.preventDefault();
        const kode = document.getElementById("kode_produk");
        if (kode) kode.focus();
        return;
    }
    
    if (e.key.toLowerCase() === "b" && e.shiftKey) {
        e.preventDefault();
        const btnBayar = document.getElementById("btn-bayar");
        if (btnBayar) {
            btnBayar.click();
            // beri waktu modal render
            setTimeout(() => {
                const diskon = document.querySelector('#modal-bayar input[name="diskon"]');
                if (diskon) diskon.focus();
            }, 120);
        }
        return;
    }

    // ESC → reset
    if (e.key === "Escape") {
        e.preventDefault();
        const btnReset = document.getElementById("btn-reset");
        if (btnReset) btnReset.click();
        return;
    }

    // TAB → keluar dari kode_produk
    if (e.key === "Tab" && active?.id === "kode_produk") {
        e.preventDefault();
        active.blur();
        return;
    }

    // ====== ENTER routing ======
    if (e.key === "Enter") {
        if (active?.name === "diskon") {
            e.preventDefault();
            e.stopPropagation();
            const bayar = document.querySelector('#modal-bayar input[name="bayar"]');
            if (bayar) bayar.focus();
            return;
        }

        if (active?.name === "bayar") {
            e.preventDefault();
            e.stopPropagation();
            const submitBtn =
                document.querySelector('#modal-bayar button[type="submit"]') ||
                document.querySelector("#modal-bayar .btn-submit-bayar");
            if (submitBtn) submitBtn.click();
            return;
        }

        if (active?.id === "kode_produk") {
            e.preventDefault();
            const qty = document.getElementById("qty");
            if (qty) qty.focus();
            return;
        }

        if (active?.id === "qty") {
            e.preventDefault();
            const btnAdd = document.getElementById("btn-add");
            if (btnAdd) {
                btnAdd.click();
                const kode = document.getElementById("kode_produk");
                if (kode) kode.focus();
            }
            return;
        }

        if (!isModalOpen() && active?.id !== "kode_produk" && active?.id !== "qty") {
            e.preventDefault();
            const btnBayar = document.getElementById("btn-bayar");
            if (btnBayar) {
                btnBayar.click();
                setTimeout(() => {
                    const diskon = document.querySelector('#modal-bayar input[name="diskon"]');
                    if (diskon) diskon.focus();
                }, 120);
            }
        }
    }
});

// Auto select Qty saat fokus
const qty = document.getElementById("qty");
if (qty) {
    qty.addEventListener("focus", function () {
        this.select();
    });
}

    }
    // QR Code Scanner (optional)
    // butuh library tambahan: html5-qrcode.min.js

    // function onScanSuccess(decodedText, decodedResult) {
    //     // tampilkan kode ke input
    //     document.getElementById("kode_produk").value = decodedText;

    //     // opsional: trigger pencarian produk via AJAX
    //     fetch(`/api/produk/${decodedText}`)
    //         .then(res => res.json())
    //         .then(data => {
    //             console.log("Produk ditemukan:", data);
    //             // bisa langsung tambahkan ke keranjang
    //         })
    //         .catch(err => console.error(err));
    // }

    // // Jalankan scanner
    // const html5QrCode = new Html5Qrcode("reader");
    // html5QrCode.start(
    // { facingMode: "environment" }, // kamera belakang kalau di HP
    // { fps: 10, qrbox: 250 },
    // onScanSuccess
    // );


});
