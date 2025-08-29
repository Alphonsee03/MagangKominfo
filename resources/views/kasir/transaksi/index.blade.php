<x-header_kasir>
    @vite('resources/js/kasir.js')
    <x-navbar_kasir />
    <x-topheader />
   
        <style>
            
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f8fafc;
            }

            .cart-item-row {
                transition: all 0.2s ease;
            }

            .cart-item-row:hover {
                background-color: #f1f5f9;
            }

            .input-focus:focus {
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            }

            #modal-bayar {
                transition: opacity 0.3s ease;
            }

            .gradient-bg {
                background: linear-gradient(135deg, #0d9488 0%, #2dd4bf 100%);
            }

            .btn-primary {
                background: linear-gradient(135deg, #4EF6A5 0%, #24D19A 100%);
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, #3dd990 0%, #1ab97f 100%);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .btn-danger {
                background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
                transition: all 0.3s ease;
            }

            .btn-danger:hover {
                background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .btn-success {
                background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
                transition: all 0.3s ease;
            }

            .btn-success:hover {
                background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .table-header {
                background: linear-gradient(135deg, #0d9488 0%, #2dd4bf 100%);
                color: white;
            }

            .empty-cart {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2rem;
                color: #94a3b8;
            }

            .cart-animation {
                animation: slideIn 0.3s ease-out;
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>

    <body>
        <div class="pc-container">
            <div class="pc-content">
                <!-- Header -->
                <div class="gradient-bg text-white p-6 rounded-b-xl shadow-md">
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center mr-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12L11 14L15 10M12 3C13.1819 3 14.3522 3.23279 15.4442 3.68508C16.5361 4.13738 17.5282 4.80031 18.364 5.63604C19.1997 6.47177 19.8626 7.46392 20.3149 8.55585C20.7672 9.64778 21 10.8181 21 12C21 13.1819 20.7672 14.3522 20.3149 15.4442C19.8626 16.5361 19.1997 17.5282 18.364 18.364C17.5282 19.1997 16.5361 19.8626 15.4442 20.3149C14.3522 20.7672 13.1819 21 12 21C10.8181 21 9.64778 20.7672 8.55585 20.3149C7.46392 19.8626 6.47177 19.1997 5.63604 18.364C4.80031 17.5282 4.13738 16.5361 3.68508 15.4442C3.23279 14.3522 3 13.1819 3 12C3 9.61305 3.94821 7.32387 5.63604 5.63604C7.32387 3.94821 9.61305 3 12 3Z" stroke="#24D19A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-white">Cashify POS</h1>
                    </div>
                    <p class="text-indigo-100">Sistem Point of Sale Modern</p>
                </div>

                <div class="p-6">
                    <!-- Input Produk -->
                    <div class="bg-white rounded-xl p-5 shadow-md mb-6">
                        <h2 class="text-lg font-semibold mb-4 text-slate-700 flex items-center">
                            <i class="fas fa-cart-plus mr-2 text-indigo-500"></i> Tambah Produk
                        </h2>
                        <div class="flex gap-4">
                            <div class="flex-1 relative">
                                <i class="fas fa-barcode absolute left-3 top-3.5 text-slate-400"></i>
                                <input
                                    id="kode_produk"
                                    type="text"
                                    placeholder="Scan / ketik kode produk..."
                                    class="w-full border rounded-lg pl-10 pr-4 py-2.5 input-focus focus:outline-none focus:border-indigo-500"
                                    autofocus>
                            </div>
                            <div class="relative">
                                <i class="fas fa-sort-numeric-up absolute left-3 top-3.5 text-slate-400"></i>
                                <input
                                    id="qty"
                                    type="number"
                                    value="1"
                                    min="1"
                                    class="w-24 border rounded-lg pl-10 pr-2 py-2.5 text-center input-focus focus:outline-none focus:border-indigo-500">
                            </div>
                            <button
                                id="btn-add"
                                class="btn-primary text-white px-5 py-2.5 rounded-lg font-medium flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i> Tambah
                            </button>
                        </div>
                    </div>

                    <!-- Cart Table -->
                    <div class="bg-white shadow rounded-xl p-5 mb-6">
                        <h2 class="text-lg font-semibold mb-4 text-slate-700 flex items-center">
                            <i class="fas fa-shopping-cart mr-2 text-indigo-500"></i> Keranjang Belanja
                        </h2>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead>
                                    <tr class="table-header rounded-t-lg">
                                        <th class="py-3 px-4 rounded-tl-lg">Kode</th>
                                        <th class="py-3 px-4">Nama</th>
                                        <th class="py-3 px-4 text-center">Qty</th>
                                        <th class="py-3 px-4 text-right">Harga</th>
                                        <th class="py-3 px-4 text-right">Subtotal</th>
                                        <th class="py-3 px-4 text-center rounded-tr-lg">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-body">
                                    <tr>
                                        <td colspan="6" class="empty-cart">
                                            <i class="fas fa-shopping-cart text-4xl mb-2"></i>
                                            <p>Keranjang belanja masih kosong</p>
                                            <p class="text-sm">Scan atau ketik kode produk untuk menambahkan item</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Total & Actions -->
                    <div class="flex justify-between items-center mt-6">
                        <div>
                            <button id="btn-reset" class="btn-danger text-white px-5 py-2.5 rounded-lg font-medium flex items-center">
                                <i class="fas fa-trash-alt mr-2"></i> Reset Cart
                            </button>
                        </div>
                        <div class="text-right bg-white p-4 rounded-xl shadow-md">
                            <p class="text-lg font-semibold text-slate-700">Total: <span id="cart-total" class="text-indigo-600">Rp 0</span></p>
                            <button
                                id="btn-bayar"
                                class="btn-success mt-3 text-white px-6 py-2.5 rounded-lg font-medium flex items-center ml-auto">
                                <i class="fas fa-credit-card mr-2"></i> Bayar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Pembayaran -->
                <div id="modal-bayar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 rounded-full gradient-bg flex items-center justify-center mr-2">
                                <i class="fas fa-receipt text-white text-sm"></i>
                            </div>
                            <h2 class="text-xl font-bold text-slate-700">Pembayaran</h2>
                        </div>

                        <form id="form-bayar">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Metode Pembayaran</label>
                                <div class="relative">
                                    <i class="fas fa-credit-card absolute left-3 top-3 text-slate-400"></i>
                                    <select name="metode_pembayaran" class="w-full border rounded-lg pl-10 pr-3 py-2.5 input-focus focus:outline-none focus:border-indigo-500">
                                        <option value="cash">Cash (Tunai)</option>
                                        <option value="qris">QRIS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Diskon (opsional)</label>
                                <div class="relative">
                                    <i class="fas fa-tag absolute left-3 top-3 text-slate-400"></i>
                                    <input type="number" name="diskon" step="0.01" placeholder="0" class="w-full border rounded-lg pl-10 pr-3 py-2.5 input-focus focus:outline-none focus:border-indigo-500">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Bayar</label>
                                <div class="relative">
                                    <i class="fas fa-money-bill-wave absolute left-3 top-3 text-slate-400"></i>
                                    <input type="number" name="bayar" step="0.01" class="w-full border rounded-lg pl-10 pr-3 py-2.5 input-focus focus:outline-none focus:border-indigo-500" required placeholder="Jumlah pembayaran">
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" id="btn-close" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-100">Batal</button>
                                <button type="submit" class="btn-success text-white px-4 py-2 rounded-lg font-medium flex items-center">
                                    <i class="fas fa-check-circle mr-2"></i> Proses
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </body>

    </html>

    <x-script-admin />

</x-header_kasir>