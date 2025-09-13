<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cashify POS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('assets/images/icontitle.svg') }}?v={{ time() }}" type="image/x-icon" />
    @vite('resources/css/app.css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');



        body::before {
            content: "";
            position: absolute;
            width: 150%;
            height: 150%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 50%, transparent 70%);
            animation: pulse 15s infinite alternate;
            top: -25%;
            left: -25%;
        }

        @keyframes pulse {
            0% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(-5%, 5%) scale(1.1);
            }

            100% {
                transform: translate(5%, -5%) scale(1);
            }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 14px 20px;
            color: white;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .btn-primary {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            border: none;
            border-radius: 12px;
            padding: 14px 20px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
        }

        .form-check-input {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .form-check-input:checked {
            background-color: #16a34a;
            border-color: #16a34a;
        }

        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: floatParticle 15s linear infinite;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(0) translateX(0) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) translateX(100vw) rotate(360deg);
                opacity: 0;
            }
        }
    </style>

</head>

<body class="min-h-screen bg-cover bg-center" style="background-image: url('assets/images/landingpage2.png');">
    <!-- Background particles -->
    <div id="particles-container" class="absolute inset-0 overflow-hidden"></div>

    <div class="flex items-center justify-center w-full min-h-screen p-4">
        <div class="w-full max-w-md mx-auto">
            <div class="glass-card p-8 rounded-2xl relative overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute -top-16 -right-16 w-32 h-32 rounded-full bg-teal-400 opacity-20 blur-xl"></div>
                <div class="absolute -bottom-16 -left-16 w-32 h-32 rounded-full bg-purple-400 opacity-20 blur-xl"></div>

                <div class="text-center mb-8 floating-element">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-md mb-4">
                        <i class="fas fa-cash-register text-4xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold bg-gradient-to-r from-teal-300 to-sky-400 bg-clip-text text-transparent mb-2">
                        Cashify POS
                    </h4>
                    <p class="text-white/70">Sistem Point of Sale Modern</p>
                </div>

                <h4 class="text-center font-bold text-white text-xl mb-6">Masuk ke Akun Anda</h4>

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-5 relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-white/60 z-10"></i>
                        <input type="email" name="email" class="w-full border rounded-xl pl-12 pr-4 py-3.5 bg-white/10 border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/40" id="floatingInput" placeholder="Alamat Email" required />
                    </div>

                    <div class="mb-5 relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-white/60 z-10"></i>
                        <input type="password" name="password" class="w-full border rounded-xl pl-12 pr-4 py-3.5 bg-white/10 border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/40" id="floatingInput1" placeholder="Kata Sandi" required />
                    </div>

                    <div class="flex mt-1 justify-between items-center mb-6">
                        <div class="flex items-center">
                            <input class="h-4 w-4 rounded bg-white/10 border-white/20 focus:ring-2 focus:ring-white/30 mr-2" type="checkbox" id="customCheckc1" />
                            <label class="text-white/80 text-sm" for="customCheckc1">Ingat saya</label>
                        </div>
                        <a href="#" class="text-sm text-teal-300 hover:text-teal-200 transition-colors">
                            Lupa Kata Sandi?
                        </a>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn-primary w-full py-3 flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                        </button>
                    </div>
                </form>

                <div class="flex justify-center items-center mt-6 pt-6 border-t border-white/10">
                    <p class="text-white/70 text-sm mr-2">Belum punya akun?</p>
                    <a href="{{ route('register') }}" class="text-teal-300 hover:text-teal-200 text-sm font-medium transition-colors">
                        Buat Akun
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Create background particles
        document.addEventListener('DOMContentLoaded', function() {
            const particlesContainer = document.getElementById('particles-container');
            const particleCount = 20;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                // Random size
                const size = Math.random() * 20 + 5;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;

                // Random position
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;

                // Random animation delay
                particle.style.animationDelay = `${Math.random() * 5}s`;
                particle.style.animationDuration = `${15 + Math.random() * 10}s`;

                particlesContainer.appendChild(particle);
            }
        });
    </script>
</body>

</html>