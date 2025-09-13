<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Cashify POS</title>
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
            z-index: 0;
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
            width: 100%;
            max-width: 560px;

        }

        .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 14px 20px 14px 45px;
            color: white;
            transition: all 0.3s ease;
            width: 100%;
            box-sizing: border-box;
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

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            z-index: 10;
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
            width: 16px;
            height: 16px;
        }

        .form-check-input:checked {
            background-color: #16a34a;
            border-color: #16a34a;
        }

        .form-radio {
            accent-color: #16a34a;
            width: 18px;
            height: 18px;
        }

        .form-radio:focus {
            outline: 2px solid rgba(34, 197, 94, 0.4);
            outline-offset: 2px;
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

        #particles-container {
            position: fixed;
            /* biar tetap menempel full layar */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            /* partikel di belakang card */
        }

        /* Card harus di atas partikel */
        .glass-card {
            position: relative;
            z-index: 10;
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

        .password-strength {
            height: 5px;
            border-radius: 3px;
            margin-top: 5px;
            transition: all 0.3s ease;
            width: 0%;
        }
    </style>
</head>

<body class="h-screen overflow-hidden bg-cover bg-center flex items-center justify-center"
    style="background-image: url('assets/images/landingpage2.png');">

    <!-- Background particles -->
    <div id="particles-container" class="absolute inset-0 overflow-hidden"></div>

    <!-- Wrapper full height -->
    <div class="flex items-center justify-center w-full h-screen px-4">
        <div class="glass-card w-full max-w-md p-6 rounded-2xl relative overflow-hidden flex flex-col justify-center">
            <!-- Decorative elements -->
            <div class="absolute -top-12 -right-12 w-24 h-24 rounded-full bg-teal-400 opacity-20 blur-xl"></div>
            <div class="absolute -bottom-12 -left-12 w-24 h-24 rounded-full bg-purple-400 opacity-20 blur-xl"></div>

            <!-- Header -->
            <div class="text-center mb-6 floating-element">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-xl bg-white/10 backdrop-blur-md mb-3 mx-auto">
                    <i class="fas fa-user-plus text-2xl text-white"></i>
                </div>
                <h4 class="text-xl font-semibold bg-gradient-to-r from-teal-300 to-sky-400 bg-clip-text text-transparent">
                    Register
                </h4>
                <p class="text-white/70 text-sm mt-1">Buat akun Cashify POS Anda</p>
            </div>

            <!-- Form -->
            <form action="{{ route('register.submit') }}" method="POST" id="registerForm" class="flex flex-col flex-1 justify-center">
                @csrf
                <div class="mb-3 relative">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="nama" class="form-control py-3" placeholder="Nama Lengkap" required>
                </div>

                <div class="mb-3 relative">
                    <i class="fas fa-at input-icon"></i>
                    <input type="text" name="username" class="form-control py-3" placeholder="Username" required>
                </div>

                <div class="mb-3 relative">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control py-3" placeholder="Email Address" required>
                </div>

                <div class="mb-3 relative">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="password" class="form-control py-3" placeholder="Password" required>
                    <div class="password-strength" id="passwordStrength"></div>
                </div>

                <div class="mb-3 relative">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password_confirmation" id="confirmPassword" class="form-control py-3" placeholder="Konfirmasi Password" required>
                    <div class="text-xs text-red-400 mt-1 hidden" id="passwordError">Password tidak cocok</div>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-medium text-white/80 text-sm">Role</label>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="role" value="admin" class="form-radio" required>
                            <span class="ml-2 text-white/80 text-sm">Admin</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="role" value="kasir" class="form-radio" required>
                            <span class="ml-2 text-white/80 text-sm">Kasir</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center mb-5">
                    <input class="form-check-input mr-2" type="checkbox" id="customCheckc1" required />
                    <label class="text-white/80 text-xs" for="customCheckc1">Saya menyetujui semua Syarat & Ketentuan</label>
                </div>

                <div class="mt-2">
                    <button type="submit" class="btn-primary w-full py-2.5 flex items-center justify-center text-sm font-semibold">
                        <i class="fas fa-user-plus mr-2"></i> Daftar
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="flex justify-center items-center mt-2 pt-2 border-t -mb-4 border-white/10">
                <p class="text-white/70 text-xs mr-2">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="text-teal-300 hover:text-teal-200 text-xs font-medium transition-colors">
                    Login
                </a>
            </div>
        </div>
    </div>
    <script>
        const particlesContainer = document.getElementById('particles-container');

        const totalParticles = 40; // tambah jumlah biar lebih ramai

        for (let i = 0; i < totalParticles; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');

            // ukuran random: kecil (8px) sampai besar (40px)
            const size = Math.random() * 32 + 8; // 8px – 40px
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;

            // posisi awal random
            particle.style.top = `${Math.random() * 100}%`;
            particle.style.left = `${Math.random() * 100}%`;

            // durasi animasi random biar beda-beda kecepatan
            particle.style.animationDuration = `${8 + Math.random() * 12}s`;

            particlesContainer.appendChild(particle);
        }
    </script>


</body>

</html>