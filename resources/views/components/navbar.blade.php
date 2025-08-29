<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <!-- Logo Header -->
        <div class="m-header flex items-center py-4 px-6 h-header-height border-b border-teal-700/30">
            <a href="#" class="b-brand flex items-center gap-3">
                <!-- Logo -->
                <div class="flex justify-center items-center w-full py-2" style="transform: scale(1.5); transform-origin: left;">
                    <!-- <img src="{{ asset('assets/images/cash-logo.svg') }}" class="h-12 w-auto mx-auto" style="max-width:180px;" /> -->
                    <svg width="130" height="35" viewBox="0 0 130 35" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="gradMain" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#A3E635" />
                                <stop offset="100%" stop-color="#65A30D" />
                            </linearGradient>
                            <linearGradient id="gradLight" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#0891b2" />
                                <stop offset="100%" stop-color="#0891b2" />
                            </linearGradient>
                            <linearGradient id="gradArc" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#1AB97F" />
                                <stop offset="100%" stop-color="#0A8E5C" />
                            </linearGradient>
                        </defs>

                        <!-- Lingkaran besar -->
                        <circle cx="18" cy="17.5" r="13" fill="url(#gradMain)" />

                        <!-- Lingkaran kecil yang diposisikan ke kanan bawah dengan warna lebih muda -->
                        <circle cx="18" cy="21.3" r="10" fill="url(#gradLight)" />

                        <!-- Centang/checkmark di tengah -->
                        <path d="M 13 17.5 L 16.5 21 L 23 13.5" fill="none" stroke="white" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />

                        <!-- Teks Cashify -->
                        <text x="40" y="18.5" font-family="Montserrat, Arial, sans-serif" font-weight="600" font-size="14" fill="#FFFFFF" dominant-baseline="middle" text-anchor="start" letter-spacing="0.5">Cashify</text>
                    </svg>
                </div>
            </a>
        </div>

        <!-- Navigation Content -->
        <div class="navbar-content h-[calc(100vh_-_74px)] py-4 overflow-y-auto">
            <ul class="pc-navbar space-y-1 px-3">
                <!-- Dashboard -->
                <li class="pc-item">
                    <a href="{{ route('admin.dashboard.index') }}" class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-home text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium ">Dashboard</span>
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                </li>

                <!-- Manajemen User -->
                <li class="pc-item">
                    <a href="{{ route('admin.users.index') }}" class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-users text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium">Manajemen User</span>
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                </li>

                <!-- Produk -->
                <li class="pc-item">
                    <a href="{{ route('admin.produks.index') }}" class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-cube text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium">Produk</span>
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                </li>

                <!-- Kategori -->
                <li class="pc-item">
                    <a href="{{ route('admin.kategoris.index') }}" class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-tags text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium">Kategori</span>
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                </li>

                <!-- Supplier -->
                <li class="pc-item">
                    <a href="{{ route('admin.suppliers.index') }}" class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-truck text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium">Supplier</span>
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                </li>

                <!-- Transaksi -->
                <li class="pc-item">
                    <a href="../pages/register-v1.html" class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200" target="_blank">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-shopping-cart text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium">Transaksi</span>
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                </li>

                <!-- Divider -->
                <li class="pc-item pc-caption my-4">
                    <div class="flex items-center px-4 py-2">
                        <i class="fas fa-chart-line text-white/40 mr-2"></i>
                        <span class="text-white/40 text-xs font-semibold uppercase tracking-wider">LAPORAN</span>
                    </div>
                </li>

                <!-- Laporan Menu -->
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link group relative flex items-center justify-between px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
                        <div class="flex items-center">
                            <span class="pc-micon mr-3">
                                <i class="fas fa-chart-bar text-lg"></i>
                            </span>
                            <span class="pc-mtext font-medium">Laporan</span>
                            <span class="pc-arrow transform transition-transform duration-200 ml-auto">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </span>
                        </div>

                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                    <ul class="pc-submenu ml-4 mt-1 space-y-1 border-l border-white/10 pl-3">
                        <li class="pc-item">
                            <a class="pc-link group relative flex items-center px-3 py-2 rounded-lg text-white/70 hover:text-white transition-all duration-200" href="#!">
                                <i class="fas fa-box text-sm mr-2"></i>
                                Stok Gudang
                                <div class="absolute inset-0 bg-white/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            </a>
                        </li>

                        <!-- Pembelian Submenu -->
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link group relative flex items-center justify-between px-3 py-2 rounded-lg text-white/70 hover:text-white transition-all duration-200">
                                <div class="flex items-center">
                                    <i class="fas fa-shopping-bag text-sm mr-2"></i>
                                    Pembelian
                                </div>
                                <div class="absolute inset-0 bg-white/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            </a>
                            <ul class="pc-submenu ml-3 mt-1 space-y-1 border-l border-white/10 pl-3">
                                <li class="pc-item">
                                    <a class="pc-link group relative flex items-center px-3 py-2 rounded-lg text-white/60 hover:text-white transition-all duration-200" href="#!">
                                        Laporan Bulanan
                                    </a>
                                </li>
                                <li class="pc-item">
                                    <a class="pc-link group relative flex items-center px-3 py-2 rounded-lg text-white/60 hover:text-white transition-all duration-200" href="#!">
                                        Laporan Supplier
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Profit Submenu -->
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link group relative flex items-center justify-between px-3 py-2 rounded-lg text-white/70 hover:text-white transition-all duration-200">
                                <div class="flex items-center">
                                    <i class="fas fa-money-bill-wave text-sm mr-2"></i>
                                    Profit
                                </div>
                                <div class="absolute inset-0 bg-white/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            </a>
                            <ul class="pc-submenu ml-3 mt-1 space-y-1 border-l border-white/10 pl-3">
                                <li class="pc-item">
                                    <a class="pc-link group relative flex items-center px-3 py-2 rounded-lg text-white/60 hover:text-white transition-all duration-200" href="#!">
                                        Laba Rugi
                                    </a>
                                </li>
                                <li class="pc-item">
                                    <a class="pc-link group relative flex items-center px-3 py-2 rounded-lg text-white/60 hover:text-white transition-all duration-200" href="#!">
                                        Penjualan Harian
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
                <li class="pc-item mt-6">
                    <a href="#!" class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-cog text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium">Pengaturan</span>
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<style>
    .pc-sidebar {
        background: linear-gradient(135deg, #3f4d67 0%, #2b2c2f 100%);
    }

    .dark .pc-sidebar {
        background: linear-gradient(135deg, #2b2c2f 0%, #1f2937 100%);
    }

    .pc-link.active {
        background: rgba(255, 255, 255, 0.15) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.36);
    }

    .pc-link.active .pc-micon,
    .pc-link.active .pc-mtext {
        color: white !important;
    }

    .pc-submenu {
        display: none;
    }

    .pc-hasmenu:hover .pc-submenu {
        display: block;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .navbar-content::-webkit-scrollbar {
        width: 4px;
    }

    .navbar-content::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .navbar-content::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }

    .navbar-content::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
</style>

<script>
    // Add active class based on current page
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const links = document.querySelectorAll('.pc-link');

        links.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });

        // Handle submenu toggle
        const hasMenuItems = document.querySelectorAll('.pc-hasmenu > .pc-link');
        hasMenuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                if (this.parentElement.classList.contains('pc-hasmenu')) {
                    e.preventDefault();
                    this.parentElement.classList.toggle('open');
                    this.querySelector('.pc-arrow').classList.toggle('rotate-90');
                }
            });
        });
    });
</script>