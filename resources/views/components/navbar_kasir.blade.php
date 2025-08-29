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
                    <a href="{{ route('kasir.dashboard.index') }}" class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/90 hover:text-white hover:bg-teal-700/30 transition-all duration-200">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-home text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium">Dashboard</span>
                        <div class="absolute inset-0 bg-teal-600/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                </li>

                <!-- Transaksi Penjualan -->
                <li class="pc-item">
                    <a href="{{ route('kasir.transaksi.index') }}" class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/90 hover:text-white hover:bg-teal-700/30 transition-all duration-200">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-cash-register text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium">Transaksi Penjualan</span>
                        <div class="absolute inset-0 bg-teal-600/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                </li>

                <!-- Riwayat Penjualan -->
                <li class="pc-item">
                    <a href="{{ route('kasir.transaksi.history') }}" class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/90 hover:text-white hover:bg-teal-700/30 transition-all duration-200">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-history text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium">Riwayat Penjualan</span>
                        <div class="absolute inset-0 bg-teal-600/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                </li>

                <!-- Laporan Harian -->
                <li class="pc-item">
                    <a href="{{ route('kasir.laporan.harian') }}" class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/90 hover:text-white hover:bg-teal-700/30 transition-all duration-200">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-chart-line text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium">Laporan Harian</span>
                        <div class="absolute inset-0 bg-teal-600/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                </li>

                <!-- Stok Gudang -->
                <li class="pc-item">
                    <a href="#" class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/90 hover:text-white hover:bg-teal-700/30 transition-all duration-200">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-boxes text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium">Stok Gudang</span>
                        <div class="absolute inset-0 bg-teal-600/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                </li>

                <!-- Logout -->
                <li class="pc-item mt-8">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="pc-link group relative flex items-center px-4 py-3 rounded-xl text-white/90 hover:text-white hover:bg-rose-600/30 transition-all duration-200">
                        <span class="pc-micon mr-3">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                        </span>
                        <span class="pc-mtext font-medium">Logout</span>
                        <div class="absolute inset-0 bg-rose-600/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm"></div>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .pc-sidebar {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
    }

    .dark .pc-sidebar {
        background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
    }

    .pc-link.active {
        background: rgba(13, 148, 136, 0.4) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
    }

    .pc-link.active .pc-micon,
    .pc-link.active .pc-mtext {
        color: white !important;
        font-weight: 600;
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

    .transition-all {
        transition: all 0.3s ease;
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
    });
</script>