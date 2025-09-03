
/* ====== Shared CSRF ====== */
const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

/* =======================
   FILTER & PAGINATION
======================= */
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchNama");
    const kategoriSelect = document.getElementById("filterKategori");
    const supplierSelect = document.getElementById("filterSupplier");
    const wrapper = document.getElementById("produkTableWrapper");

    function loadProduk() {
        let params = new URLSearchParams();
        if (searchInput.value) params.append("search", searchInput.value);
        if (kategoriSelect.value)
            params.append("kategori_id", kategoriSelect.value);
        if (supplierSelect.value)
            params.append("supplier_id", supplierSelect.value);

        fetch(`?${params.toString()}`, {
            headers: { "X-Requested-With": "XMLHttpRequest" },
        })
            .then((res) => res.text())
            .then((html) => {
                wrapper.innerHTML = html;
            })
            .catch((err) => console.error(err));
    }

    // debounce untuk search
    let debounce;
    searchInput?.addEventListener("input", () => {
        clearTimeout(debounce);
        debounce = setTimeout(loadProduk, 500);
    });

    kategoriSelect?.addEventListener("change", loadProduk);
    supplierSelect?.addEventListener("change", loadProduk);

    // pagination via ajax
    wrapper?.addEventListener("click", (e) => {
        if (e.target.tagName === "A" && e.target.closest(".pagination")) {
            e.preventDefault();
            fetch(e.target.href, {
                headers: { "X-Requested-With": "XMLHttpRequest" },
            })
                .then((res) => res.text())
                .then((html) => (wrapper.innerHTML = html));
        }
    });
});

/* =======================
   MODAL STOK
======================= */
const stokModal = document.getElementById("stokModal");
const stokProdukId = document.getElementById("stokProdukId");
const stokForm = document.getElementById("stokForm");
const jumlahStok = document.getElementById("jumlahStok");

function openStokModal(id) {
    stokProdukId.value = id;
    jumlahStok.value = "";
    stokModal.classList.remove("hidden");
    stokModal.classList.add("flex");
    jumlahStok.focus();
}
function closeStokModal() {
    stokModal.classList.add("hidden");
    stokModal.classList.remove("flex");
}

document
    .getElementById("btnCancelStok")
    ?.addEventListener("click", closeStokModal);

// submit stok
document.addEventListener("DOMContentLoaded", () => {
    const stokForm = document.getElementById("stokForm");
    const stokProdukId = document.getElementById("stokProdukId");
    const jumlahStok = document.getElementById("jumlahStok");

    // Memeriksa apakah elemen yang diperlukan ada sebelum menambahkan event listener
    if (stokForm && stokProdukId && jumlahStok) {
        stokForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const id = stokProdukId.value;
            const jumlah = parseInt(jumlahStok.value);

            if (isNaN(jumlah) || jumlah <= 0) {
                alert("Jumlah stok harus lebih dari 0");
                return;
            }

            const formData = new FormData();
            formData.append("_token", csrfToken);
            formData.append("stok", jumlah);

            fetch(`/admin/produks/${id}/update-stok`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: formData,
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        document.getElementById("stok-" + id).innerText =
                            data.stok_baru;
                        closeStokModal();
                        alert("Stok berhasil ditambahkan!");
                    } else {
                        alert(data.message || "Gagal update stok");
                    }
                })
                .catch((err) => {
                    console.error("Error:", err);
                    alert("Gagal update stok");
                });
        });
    } else {
        console.warn("Elemen stokForm, stokProdukId, atau jumlahStok tidak ditemukan di DOM.");
    }
});


/* =======================
   MODAL PRODUK
======================= */
const produkModal = document.getElementById("produkModal");
const produkForm = document.getElementById("produkForm");
const produkIdField = document.getElementById("produkIdField");
const methodField = document.getElementById("methodField");
const modalTitle = document.getElementById("produkModalTitle");

// buka tambah produk
document.getElementById("btnTambahProduk")?.addEventListener("click", () => {
    modalTitle.innerText = "Tambah Produk";
    produkForm.reset();
    produkIdField.value = "";
    methodField.value = "POST";

    const supplierSelect = document.getElementById("suppliers");
    Array.from(supplierSelect.options).forEach((opt) => (opt.selected = false));

    produkModal.classList.remove("hidden");
    produkModal.classList.add("flex");
});

function closeProdukModal() {
    produkModal.classList.add("hidden");
    produkModal.classList.remove("flex");
}

// close modal
document.getElementById("btnCancelProduk")
    ?.addEventListener("click", closeProdukModal);

// submit produk
produkForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const submitBtn = document.getElementById("submitBtn");
    const originalText = submitBtn.textContent;
    submitBtn.textContent = "Menyimpan...";
    submitBtn.disabled = true;

    const id = produkIdField.value;
    const formData = new FormData(produkForm);
    const isEdit = methodField.value === "PUT";
    const url = isEdit ? `/admin/produks/${id}` : "/admin/produks";

    fetch(url, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            "X-Requested-With": "XMLHttpRequest",
            Accept: "application/json",
        },
        body: formData,
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                if (!isEdit) {
                    tambahRowProduk(data.produk);
                } else {
                    updateRowProduk(data.data);
                }
                refreshRowNumbers();
                closeProdukModal();
                alert(data.message || "Produk berhasil disimpan!");
            } else {
                throw new Error(data.message || "Terjadi kesalahan");
            }
        })
        .catch((err) => {
            console.error("Error:", err);
            alert(err.message || "Terjadi kesalahan saat menyimpan produk");
        })
        .finally(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
});


/* =======================
   UPDATE TABLE DOM
======================= */
function refreshRowNumbers() {
    document.querySelectorAll("#produkTableBody tr").forEach((row, i) => {
        let noCell = row.querySelector("td:first-child");
        if (noCell) noCell.textContent = i + 1;
    });
}
function tambahRowProduk(produk) {
    const tbody = document.getElementById("produkTableBody");
    const row = buildRow(produk);
    tbody.prepend(row);
}
function updateRowProduk(produk) {

    const oldRow = document.querySelector(
        `#produkTableBody tr[data-id="${produk.id}"]`
    );

    if (oldRow) { 
        oldRow.replaceWith(buildRow(produk));
    } else {
        console.error('Baris produk tidak ditemukan untuk ID:', produk.id);
    }
}
function buildRow(produk) {
    const tr = document.createElement("tr");
    tr.className = "hover:bg-gray-50 transition";
    tr.setAttribute("data-id", produk.id);
    console.log('Data :', produk);
    tr.innerHTML = `
        <td class="px-4 py-2 font-medium text-gray-600"></td>
        <td class="px-4 py-2 font-bold text-center">${produk.kode_produk}</td>
        <td class="px-4 py-2 font-semibold text-gray-800 text-center">${produk.nama}</td>
        <td class="px-4 py-2">${produk.kategori.nama ?? "-"}</td>
        <td class="px-4 py-2 text-gray-700">Rp ${formatRupiah(
            produk.harga_beli
        )}</td>
        <td class="px-4 py-2 text-gray-700">Rp ${formatRupiah(
            produk.harga_jual
        )}</td>
        <td class="px-4 py-2">
            <span id="stok-${
                produk.id
            }" class="px-2 py-1 rounded bg-teal-100 text-teal-700 text-sm">
                ${produk.stok}
            </span>
        </td>
        <td class="px-4 py-2 flex items-center justify-center space-x-2">
            <button type="button" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm btn-edit"
                data-produk='${JSON.stringify(produk)}'>✏️</button>

            <form action="/admin/produks/${
                produk.id
            }" method="POST" class="inline delete-form">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" onclick="return confirm('Yakin hapus?')"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm">🗑️</button>
            </form>

            <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm btn-stok"
                data-id="${produk.id}">➕</button>
        </td>
    `;
    return tr;
}
function formatRupiah(angka) {
    return new Intl.NumberFormat("id-ID").format(angka);
}

/* =======================
   EVENT DELEGATION
======================= */
document.addEventListener("click", (e) => {
    // edit produk
    if (e.target.classList.contains("btn-edit")) {
        const produk = JSON.parse(e.target.dataset.produk);
       
        modalTitle.innerText = "Edit Produk";
        produkIdField.value = produk.id;
        methodField.value = "PUT";
        document.getElementById("kode_produk").value = produk.kode_produk || "";
        document.getElementById("nama").value = produk.nama || "";
        document.getElementById("kategori_id").value = produk.kategori_id || "";
        document.getElementById("harga_beli").value = produk.harga_beli || "";
        document.getElementById("harga_jual").value = produk.harga_jual || "";
        document.getElementById("stok").value = produk.stok || 0;
        document.getElementById("deskripsi").value = produk.deskripsi || "";
        const supplierSelect = document.getElementById("suppliers");
        Array.from(supplierSelect.options).forEach((opt) => {
            opt.selected = produk.suppliers?.includes(opt.value) || false;
        });
        produkModal.classList.remove("hidden");
        produkModal.classList.add("flex");
    }

    // tambah stok
    if (e.target.classList.contains("btn-stok")) {
        openStokModal(e.target.dataset.id);
    }

    // klik di luar modal → tutup
    if (e.target === produkModal) closeProdukModal();
    if (e.target === stokModal) closeStokModal();
});

