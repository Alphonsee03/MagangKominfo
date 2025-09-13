<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashify - Modern Point of Sale System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('assets/images/icontitle.svg') }}?v={{ time() }}" type="image/x-icon" />
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #10b981;
            --text-color: #1f2937;
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .neumorphism {
            border-radius: 16px;
            background: linear-gradient(145deg, #f0f0f0, #cacaca);
            box-shadow: 5px 5px 10px #bebebe,
                -5px -5px 10px #ffffff;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #6366f1 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid white;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: white;
            color: var(--primary-color);
        }

        .logo-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            background: linear-gradient(135deg, #10b981 0%, #0ea5e9 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .feature-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .feature-card:hover::before {
            left: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
        }
    </style>
</head>

<body class="pattern-overlay" style="background-image: url('assets/images/landingpage2.png');">
    <!-- Header/Navigation -->
    <header class="container mx-auto px-6 py-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <!-- Logo Area - Ganti dengan logo asli Anda -->
                <div class="w-14 h-14 rounded-xl glass-card flex items-center justify-center mr-1 p-1">
                    <svg width="100%" height="100%" viewBox="5 4 27 27" xmlns="http://www.w3.org/2000/svg">
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
                    </svg>
                </div>
                <h1 class="logo-text text-3xl">Cashify</h1>
            </div>

            <nav class="hidden md:flex space-x-2">
                <a href="#" id="docsBtn" class="px-4 py-2 rounded-lg text-white font-medium hover:bg-white hover:bg-opacity-10 transition">Docs</a>
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-white font-medium hover:bg-white hover:bg-opacity-10 transition">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg text-white font-medium bg-white bg-opacity-20 hover:bg-opacity-30 transition">Register</a>
            </nav>

            <!-- Mobile menu button -->
            <button class="md:hidden text-white">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-16 md:py-24 relative">
        <!-- Background elements -->
        <div class="absolute top-10 left-1/4 w-72 h-72 rounded-full bg-blue-400 opacity-10 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-1/4 w-72 h-72 rounded-full bg-green-400 opacity-10 blur-3xl animate-pulse" style="animation-delay: 1s;"></div>

        <div class="max-w-2xl mx-auto text-center relative z-10 -mt-14">
            <div class="mb-8">
                <!-- Badge/Tagline -->
                <div class="inline-flex items-center glass-card px-4 py-2 rounded-full mb-6">
                    <span class="text-sm text-white font-medium">✨Modern POS for Smart Business🚀</span>
                </div>
            </div>

            <h1 class="hero-title text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Modern Point of Sale untuk
                <span class="bg-gradient-to-r from-green-300 to-cyan-300 bg-clip-text text-transparent">Bisnis Masa Kini</span>
            </h1>

            <p class="text-xl text-white text-opacity-90 mb-10 leading-relaxed">
                Kelola penjualan, inventori, dan pelaporan dengan sistem POS tercanggih yang dirancang khusus untuk kebutuhan bisnis Anda.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-8">
                <a href="#" id="getBtn" class="btn-glassmorphism py-4 px-8 rounded-xl inline-flex items-center justify-center group">
                    <span class="text-white font-semibold">Get Started</span>
                    <i class="fas fa-arrow-right ml-2 text-white transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- Stats/Trust indicators -->
            <div class="glass-card p-6 rounded-2xl mt-6">
                <div class="grid grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">298+</div>
                        <div class="text-white text-opacity-70 text-sm">Bisnis Terpercaya</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">86.98%</div>
                        <div class="text-white text-opacity-70 text-sm">Uptime</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">24/7</div>
                        <div class="text-white text-opacity-70 text-sm">Support</div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .btn-glassmorphism {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(25px);
                border-radius: 12px;
                border: 1.5px solid rgba(255, 255, 255, 0.18);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
                transition: all 0.3s ease;
            }

            .btn-glassmorphism:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.5);
                background: rgba(255, 255, 255, 0.15);
            }

            .btn-glassmorphism-secondary {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(25px);
                border-radius: 12px;
                border: 1.5px solid rgba(255, 255, 255, 0.1);
                transition: all 0.3s ease;
            }

            .btn-glassmorphism-secondary:hover {
                transform: translateY(-2px);
                background: rgba(255, 255, 255, 0.1);
            }
        </style>
    </section>

    <!-- Features Section -->
    <section class="container mx-auto px-6 py-16 md:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-16 items-start">
            <!-- Text Content - Now occupies 2 columns -->
            <div class="lg:col-span-2">
                <div class="sticky top-24">
                    <div class="inline-flex items-center glass-card px-5 py-3 rounded-full mb-8">
                        <span class="text-sm text-white font-medium">✨ KEUNGGULAN KAMI</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-8 leading-tight">
                        Mengapa Bisnis
                        <span class="bg-gradient-to-r from-green-300 to-cyan-300 bg-clip-text text-transparent">Memilih Cashify?</span>
                    </h2>
                    <p class="text-xl text-white text-opacity-90 mb-8 leading-relaxed">
                        Solusi lengkap untuk mengelola transaksi penjualan bisnis Anda dengan antarmuka intuitif dan fitur canggih. Cashify membantu Anda memantau stok, laporan keuangan, serta memberikan insight mendalam agar bisnis terus berkembang. Semua kemudahan ini hadir dalam satu platform yang aman, cepat, dan mudah digunakan, sehingga Anda bisa lebih fokus pada pertumbuhan usaha dan kepuasan pelanggan.
                    </p>

                    <!-- Additional stats -->
                    <div class="glass-card p-6 rounded-2xl mt-10">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-400">98%</div>
                                <div class="text-white text-opacity-70 text-sm">Kepuasan Pengguna</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-400">4.9/5</div>
                                <div class="text-white text-opacity-70 text-sm">Rating</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature Cards - Now occupies 3 columns with improved layout -->
            <div class="lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Feature 1 - Enhanced -->
                    <div class="glass-card p-8 rounded-2xl feature-card group hover:bg-white hover:bg-opacity-15 transition-all duration-300">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-400 to-cyan-500 flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-bolt text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-white mb-4 group-hover:text-green-300 transition-colors">Transaksi Super Cepat</h3>
                        <p class="text-white text-opacity-80 leading-relaxed">Proses checkout yang dipercepat dengan teknologi terkini, mengurangi waktu tunggu pelanggan hingga 70%.</p>
                        <div class="mt-6 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-green-400 text-sm font-medium">→ Lebih efisien</span>
                        </div>
                    </div>

                    <!-- Feature 2 - Enhanced -->
                    <div class="glass-card p-8 rounded-2xl feature-card group hover:bg-white hover:bg-opacity-15 transition-all duration-300">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-chart-line text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-white mb-4 group-hover:text-blue-300 transition-colors">Analitik Real-time</h3>
                        <p class="text-white text-opacity-80 leading-relaxed">Pantau performa bisnis Anda dengan analitik mendetail dan laporan yang selalu terupdate secara real-time.</p>
                        <div class="mt-6 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-blue-400 text-sm font-medium">→ Data akurat</span>
                        </div>
                    </div>

                    <!-- Feature 3 - Enhanced -->
                    <div class="glass-card p-8 rounded-2xl feature-card group hover:bg-white hover:bg-opacity-15 transition-all duration-300">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-mobile-alt text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-white mb-4 group-hover:text-purple-300 transition-colors">Multi-Device Support</h3>
                        <p class="text-white text-opacity-80 leading-relaxed">Akses sistem dari perangkat apa pun - desktop, tablet, atau mobile dengan experience yang konsisten.</p>
                        <div class="mt-6 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-purple-400 text-sm font-medium">→ Fleksibel</span>
                        </div>
                    </div>

                    <!-- Feature 4 - Enhanced -->
                    <div class="glass-card p-8 rounded-2xl feature-card group hover:bg-white hover:bg-opacity-15 transition-all duration-300">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-red-400 to-orange-500 flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-shield-alt text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-white mb-4 group-hover:text-red-300 transition-colors">Keamanan Enterprise</h3>
                        <p class="text-white text-opacity-80 leading-relaxed">Data bisnis Anda terlindungi dengan enkripsi tingkat militer dan backup otomatis setiap hari.</p>
                        <div class="mt-6 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-red-400 text-sm font-medium">→ Terlindungi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Get Started -->
    <div id="modal-get-started" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="glass-card rounded-2xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-white">Pilih Paket Cashify</h2>
                <button id="close-get-started" class="text-white text-opacity-70 hover:text-opacity-100">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Paket Starter -->
                <div class="glass-card p-6 rounded-xl text-center">
                    <h3 class="text-xl font-semibold text-white mb-4">Starter</h3>
                    <div class="text-3xl font-bold text-white mb-4">Rp 50rb<span class="text-sm text-white text-opacity-70">/bulan</span></div>
                    <ul class="text-white text-opacity-80 mb-6 space-y-2">
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> 1 Outlet</li>
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> 2 Pengguna</li>
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> Dukungan Email</li>
                        <li><i class="fas fa-times-circle text-red-400 mr-2"></i> Laporan Lanjutan</li>
                    </ul>
                    <button class="btn-primary w-full py-3 rounded-xl font-semibold">Pilih Paket</button>
                </div>

                <!-- Paket Business -->
                <div class="glass-card p-6 rounded-xl text-center border-2 border-green-400 transform scale-105">
                    <div class="bg-green-400 text-white text-sm font-bold py-1 px-3 rounded-full inline-block mb-4">POPULER</div>
                    <h3 class="text-xl font-semibold text-white mb-4">Business</h3>
                    <div class="text-3xl font-bold text-white mb-4">Rp 150rb<span class="text-sm text-white text-opacity-70">/bulan</span></div>
                    <ul class="text-white text-opacity-80 mb-6 space-y-2">
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> 3 Outlet</li>
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> 5 Pengguna</li>
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> Dukungan Prioritas</li>
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> Laporan Lanjutan</li>
                    </ul>
                    <button class="btn-primary w-full py-3 rounded-xl font-semibold">Pilih Paket</button>
                </div>

                <!-- Paket Enterprise -->
                <div class="glass-card p-6 rounded-xl text-center">
                    <h3 class="text-xl font-semibold text-white mb-4">Enterprise</h3>
                    <div class="text-3xl font-bold text-white mb-4">Rp 350rb<span class="text-sm text-white text-opacity-70">| Unlimited</span></div>
                    <ul class="text-white text-opacity-80 mb-6 space-y-2">
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> Outlet Unlimited</li>
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> Pengguna Unlimited</li>
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> Dukungan 24/7</li>
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> Fitur Kustom</li>
                    </ul>
                    <button class="btn-primary w-full py-3 rounded-xl font-semibold">Hubungi Sales</button>
                </div>
            </div>

            <div class="text-center">
                <p class="text-white text-opacity-80">Sudah punya akun? <a href="{{ route('login') }}" class="text-green-400 hover:text-green-300">Login</a></p>
            </div>
        </div>
    </div>

    <!-- Modal Docs -->
    <div id="modal-docs" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="glass-card rounded-2xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-white">Dokumentasi Cashify</h2>
                <button id="close-docs" class="text-white text-opacity-70 hover:text-opacity-100">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Panduan Instalasi -->
                <a href="#" class="glass-card p-6 rounded-xl hover:bg-white hover:bg-opacity-20 transition">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-lg bg-white bg-opacity-10 flex items-center justify-center mr-4">
                            <i class="fas fa-download text-xl text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Panduan Instalasi</h3>
                    </div>
                    <p class="text-white text-opacity-80">Pelajari cara instal dan setup Cashify di sistem Anda</p>
                </a>

                <!-- Tutorial Penggunaan -->
                <a href="#" class="glass-card p-6 rounded-xl hover:bg-white hover:bg-opacity-20 transition">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-lg bg-white bg-opacity-10 flex items-center justify-center mr-4">
                            <i class="fas fa-book-open text-xl text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Tutorial Penggunaan</h3>
                    </div>
                    <p class="text-white text-opacity-80">Panduan lengkap menggunakan fitur-fitur Cashify</p>
                </a>

                <!-- API Documentation -->
                <a href="#" class="glass-card p-6 rounded-xl hover:bg-white hover:bg-opacity-20 transition">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-lg bg-white bg-opacity-10 flex items-center justify-center mr-4">
                            <i class="fas fa-code text-xl text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white">API Documentation</h3>
                    </div>
                    <p class="text-white text-opacity-80">Integrasikan Cashify dengan sistem lain menggunakan API</p>
                </a>

                <!-- Video Tutorials -->
                <a href="#" class="glass-card p-6 rounded-xl hover:bg-white hover:bg-opacity-20 transition">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-lg bg-white bg-opacity-10 flex items-center justify-center mr-4">
                            <i class="fas fa-video text-xl text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Video Tutorials</h3>
                    </div>
                    <p class="text-white text-opacity-80">Belajar melalui video panduan langkah demi langkah</p>
                </a>
            </div>

            <div class="glass-card p-6 rounded-xl">
                <h3 class="text-lg font-semibold text-white mb-4">Butuh Bantuan?</h3>
                <p class="text-white text-opacity-80 mb-4">Tim support kami siap membantu Anda 24/7</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#" class="btn-primary py-3 px-6 rounded-xl font-semibold text-center">
                        <i class="fas fa-envelope mr-2"></i> Email Support
                    </a>
                    <a href="#" class="btn-secondary py-3 px-6 rounded-xl font-semibold text-center">
                        <i class="fas fa-comments mr-2"></i> Live Chat
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer/Contact Section -->
    <footer class="glass-card mt-24 py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-xl bg-white bg-opacity-10 flex items-center justify-center mr-3">
                            <i class="fas fa-cash-register text-xl text-white"></i>
                        </div>
                        <h2 class="logo-text text-2xl">Cashify</h2>
                    </div>
                    <p class="text-white text-opacity-80 mb-6">Solusi Point of Sale modern untuk mengoptimalkan operasional bisnis Anda.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white bg-opacity-10 flex items-center justify-center text-white hover:bg-opacity-20 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white bg-opacity-10 flex items-center justify-center text-white hover:bg-opacity-20 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com/ali_suaidy/" class="w-10 h-10 rounded-full bg-white bg-opacity-10 flex items-center justify-center text-white hover:bg-opacity-20 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/moh-suaidi-ali-740351337" class="w-10 h-10 rounded-full bg-white bg-opacity-10 flex items-center justify-center text-white hover:bg-opacity-20 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-white font-semibold text-lg mb-6">Kontak Kami</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-white text-opacity-80 mt-1 mr-3"></i>
                            <span class="text-white text-opacity-80">Banaresep Timur, Kec. Lenteng, Sumenep</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone text-white text-opacity-80 mt-1 mr-3"></i>
                            <span class="text-white text-opacity-80">+62 8383 1610 416</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope text-white text-opacity-80 mt-1 mr-3"></i>
                            <span class="text-white text-opacity-80">aditvikstor@gmail.com</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-semibold text-lg mb-6">Tentang Kami</h3>
                    <p class="text-white text-opacity-80 mb-6">Cashify dikembangkan oleh mahasiswa Universitas Bahauddin Mudhary Madura yang berkomitmen menghadirkan solusi inovatif untuk bisnis di Indonesia.</p>
                    <a href="#" class="text-white font-medium inline-flex items-center hover:text-opacity-80 transition">
                        <span>Pelajari Selengkapnya</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <div class="border-t border-white border-opacity-10 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-white text-opacity-70 text-sm">© 2025 Cashify. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-white text-opacity-70 text-sm hover:text-opacity-100 transition">Privacy Policy</a>
                    <a href="#" class="text-white text-opacity-70 text-sm hover:text-opacity-100 transition">Terms of Service</a>
                    <a href="#" class="text-white text-opacity-70 text-sm hover:text-opacity-100 transition">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Simple animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const featureCards = document.querySelectorAll('.feature-card');
            const getStartedBtn = document.querySelector('#getBtn');
            const getStartedModal = document.getElementById('modal-get-started');
            const closeGetStarted = document.getElementById('close-get-started');
            const heroTitle = document.querySelector('.hero-title');

            heroTitle.style.opacity = '0';
            heroTitle.style.transform = 'translateY(20px)';
            setTimeout(() => {
                heroTitle.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
                heroTitle.style.opacity = '1';
                heroTitle.style.transform = 'translateY(0)';
            }, 300);

            featureCards.forEach((card, index) => {
                // Add delay for staggered animation
                card.style.transitionDelay = `${index * 0.1}s`;
            });

            getStartedBtn.addEventListener('click', function(e) {
                e.preventDefault();
                getStartedModal.classList.remove('hidden');
            });

            closeGetStarted.addEventListener('click', function() {
                getStartedModal.classList.add('hidden');
            });

            // Docs Modal
            const docsBtn = document.querySelector('#docsBtn');
            const docsModal = document.getElementById('modal-docs');
            const closeDocs = document.getElementById('close-docs');

            docsBtn.addEventListener('click', function(e) {
                e.preventDefault();
                docsModal.classList.remove('hidden');
            });

            closeDocs.addEventListener('click', function() {
                docsModal.classList.add('hidden');
            });

            // Close modal when clicking outside
            [getStartedModal, docsModal].forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                    }
                });
            });

        });
    </script>
</body>

</html>