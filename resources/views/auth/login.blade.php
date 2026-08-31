<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Gamifikasi PKBM Terang Mulia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Google --}}
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Space+Grotesk:wght@400;700&family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; overflow: hidden; }
        
        .font-game { font-family: 'Lilita One', cursive; }
        .font-tech { font-family: 'Space Grotesk', sans-serif; }

        /* --- BACKROUND SHADER CANVAS --- */
        #bg-shader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.9;
        }

        /* --- ANIMASI --- */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }

        /* Style untuk Partikel JS (Kanan) */
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.25); /* Ubah menjadi putih transparan untuk kontras pada panel biru */
            border-radius: 50%;
            pointer-events: none;
            bottom: -50px;
            z-index: 10;
        }

        /* Shadow Maskot */
        .mascot-glow {
            filter: drop-shadow(0 0 35px rgba(251, 245, 220, 0.6));
            transition: filter 0.3s ease, transform 0.3s ease;
        }
        .mascot-glow:hover {
            filter: drop-shadow(0 0 50px rgba(251, 245, 220, 0.85)) scale(1.02);
        }

        /* 3D Spin Animation */
        @keyframes spin-once {
            0% { transform: scale(1) rotateY(0deg); }
            50% { transform: scale(1.1) rotateY(180deg); }
            100% { transform: scale(1) rotateY(360deg); }
        }
        .animate-spin-once {
            animation: spin-once 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* --- BUBBLE FLOATING ANIMATIONS --- */
        @keyframes bubble-float-1 {
            0%, 100% { transform: translateY(0) translateX(0) scale(1); }
            33% { transform: translateY(-12px) translateX(8px) scale(1.05); }
            66% { transform: translateY(6px) translateX(-6px) scale(0.95); }
        }
        @keyframes bubble-float-2 {
            0%, 100% { transform: translateY(0) translateX(0) scale(1); }
            50% { transform: translateY(18px) translateX(-12px) scale(1.1); }
        }
        @keyframes bubble-float-3 {
            0%, 100% { transform: translateY(0) translateX(0) scale(1); }
            50% { transform: translateY(-15px) translateX(15px) scale(0.9); }
        }
        .animate-bubble-1 { animation: bubble-float-1 8s ease-in-out infinite; }
        .animate-bubble-2 { animation: bubble-float-2 10s ease-in-out infinite; }
        .animate-bubble-3 { animation: bubble-float-3 7s ease-in-out infinite; }

        /* Semi-transparent cream background for left scene */
        .bg-cream-semi {
            background-color: rgba(250, 249, 245, 0.88);
            backdrop-filter: blur(12px);
        }

        /* Override Chrome autofill styles to match dark blue inputs */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 100px #0149a6 inset !important;
            -webkit-text-fill-color: #ffffff !important;
            caret-color: #ffffff !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* --- GAMIFICATION AURA & SPIN KEYFRAMES --- */
        @keyframes spin-slow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 20s linear infinite;
        }
        @keyframes aura-pulse {
            0%, 100% { transform: translate(-50%, -50%) scale(0.95); opacity: 0.55; }
            50% { transform: translate(-50%, -50%) scale(1.1); opacity: 0.85; }
        }
        .animate-aura-pulse {
            animation: aura-pulse 5s ease-in-out infinite;
        }

        /* --- LUKA TEXT TYPING ANIMATION (8s loop) --- */
        @keyframes typing-luka {
            0% { width: 0; }
            6.25% { width: 35px; }
            12.5% { width: 70px; }
            18.75% { width: 105px; }
            25%, 98% { width: 140px; }
            99%, 100% { width: 0; }
        }
        @keyframes cursor-luka {
            0%, 8%, 16%, 24%, 32% { border-right-color: #f97316; }
            4%, 12%, 20%, 28%, 36%, 100% { border-right-color: transparent; }
        }
        .animate-typing-luka {
            display: inline-block;
            overflow: hidden;
            white-space: nowrap;
            border-right: 4px solid transparent;
            width: 0;
            vertical-align: middle;
            flex-shrink: 0;
            animation: 
                typing-luka 8s infinite,
                cursor-luka 8s infinite;
        }

        /* --- THE MENTOR DIGITAL TYPING ANIMATION --- */
        @keyframes typing-mentor {
            0%, 25% { width: 0; }
            50%, 98% { width: 85px; }
            99%, 100% { width: 0; }
        }
        @keyframes cursor-mentor {
            0%, 24.9% { border-right-color: transparent; }
            25%, 33%, 41%, 49% { border-right-color: #f97316; }
            29%, 37%, 45%, 50%, 100% { border-right-color: transparent; }
        }
        .animate-typing-mentor {
            display: inline-block;
            overflow: hidden;
            border-right: 3px solid transparent;
            width: 0;
            vertical-align: middle;
            flex-shrink: 0;
            animation: 
                typing-mentor 8s infinite,
                cursor-mentor 8s infinite;
        }

        @media (min-width: 768px) {
            @keyframes typing-luka {
                0% { width: 0; }
                6.25% { width: 44px; }
                12.5% { width: 88px; }
                18.75% { width: 132px; }
                25%, 98% { width: 175px; }
                99%, 100% { width: 0; }
            }
            @keyframes typing-mentor {
                0%, 25% { width: 0; }
                50%, 98% { width: 90px; }
                99%, 100% { width: 0; }
            }
        }
    </style>
</head>
<body class="bg-black min-h-screen flex items-center justify-center relative overflow-hidden">

    {{-- Toast Notification --}}
    @if ($errors->any())
        <div id="error-toast" class="fixed top-5 right-5 z-50 flex items-center w-full max-w-sm p-4 mb-4 text-slate-800 bg-white rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.2)] border-l-4 border-rose-500 transform translate-x-[120%] transition-transform duration-500 ease-out" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-rose-500 bg-rose-100 rounded-xl">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                </svg>
            </div>
            <div class="ms-3 text-sm font-medium pr-6">
                <span class="font-bold text-rose-600 block text-sm mb-0.5">Login Gagal</span>
                <span class="text-slate-500 text-xs leading-relaxed font-semibold">Email atau password yang dimasukan salah silahkan masukan email dan password dengan benar.</span>
            </div>
            <button type="button" onclick="dismissToast()" class="ms-auto -mx-1.5 -my-1.5 bg-white text-slate-400 hover:text-slate-900 rounded-lg focus:ring-2 focus:ring-slate-300 p-1.5 hover:bg-slate-100 inline-flex items-center justify-center h-8 w-8 transition-all" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
            {{-- Progress bar at the bottom --}}
            <div class="absolute bottom-0 left-0 h-1 bg-rose-500 rounded-bl-2xl transition-all duration-[5000ms] ease-linear w-full" id="toast-progress"></div>
        </div>
    @endif

    {{-- Shader Background Canvas --}}
    <canvas id="bg-shader"></canvas>

    <div class="w-full h-screen flex flex-row relative z-10 bg-transparent transition-colors duration-[1000ms]" id="login-wrapper">

        {{-- ================================================== --}}
        {{-- BAGIAN KIRI: Putih/Terang + Maskot Parallax --}}
        {{-- ================================================== --}}
        <div class="w-full h-full bg-transparent relative flex items-center justify-center overflow-hidden transition-all duration-[1000ms] ease-in-out z-20" id="left-scene">

            {{-- Logo Sekolah (Pojok Kiri Atas) --}}
            <div id="logo-container" class="absolute top-8 left-8 flex items-center gap-3 z-30 opacity-0 transition-opacity duration-[1000ms] pointer-events-none">
                <img src="{{ asset('img/logo_sekolah.png') }}" class="w-12 h-12 object-contain">
                <div>
                    <h1 id="logo-title" class="text-base font-bold text-[#0252b9] uppercase tracking-wider">Gamifikasi</h1>
                    <p id="logo-subtitle" class="text-xs text-slate-500 font-semibold">PKBM Terang Mulia</p>
                </div>
            </div>

            {{-- Container Parallax --}}
            <div class="relative z-10 p-10 text-center flex flex-col items-center justify-center" id="parallax-container">

                {{-- Aura Gamifikasi Energi/Quest --}}
                <div id="mascot-aura" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] rounded-full blur-[65px] opacity-0 transition-opacity duration-[1000ms] -z-10 pointer-events-none animate-aura-pulse">
                    <div class="w-full h-full bg-gradient-to-tr from-amber-400 via-cyan-400 to-indigo-500 rounded-full animate-spin-slow"></div>
                </div>

                {{-- Elemen Dekorasi (Bola-bola melayang di belakang) --}}
                <div id="decor-bubbles" class="opacity-0 transition-opacity duration-[1000ms] pointer-events-none">
                    <div data-depth="0.2" class="absolute top-10 left-10 w-28 h-28 bg-blue-300 rounded-full blur-2xl opacity-60 animate-bubble-1"></div>
                    <div data-depth="0.5" class="absolute bottom-20 right-40 w-56 h-56 bg-blue-500 rounded-full blur-[80px] opacity-40 animate-bubble-2"></div>
                    <div data-depth="0.1" class="absolute top-40 right-10 w-16 h-16 bg-indigo-300 rounded-full opacity-40 animate-bubble-3"></div>
                </div>

                {{-- MASKOT INTERAKTIF --}}
                <div data-depth="0.3" class="relative group cursor-pointer flex flex-col items-center" onclick="unlockLogin()">

                    {{-- Glow Kuning Lembut di Belakang Maskot --}}
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-amber-200/40 rounded-full blur-[60px] -z-10 animate-pulse" id="mascot-glow"></div>

                    {{-- Bayangan pijakan maskot --}}
                    <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 w-64 h-6 bg-slate-900/10 blur-md rounded-[100%]"></div>

                    <img src="{{ asset('img/maskot.png') }}"
                         class="w-56 md:w-72 object-contain mascot-glow"
                         alt="Maskot"
                         id="mascot-img">

                    {{-- Petunjuk Ketuk/Klik (Hanya muncul saat Locked) --}}
                    <div id="unlock-instruction" class="mt-8 text-white/50 text-xs font-semibold tracking-[0.2em] uppercase select-none transition-all duration-500 hover:text-white animate-pulse">
                        Click to Unlock
                    </div>
                </div>

                {{-- Branding LUKA - The Mentor Digital --}}
                <div id="left-branding-container" class="mt-8 flex items-center gap-5 opacity-0 scale-95 blur-sm transition-all duration-[1000ms] pointer-events-none select-none hover:scale-105 transition-all duration-300">
                    {{-- Nama LUKA dengan Efek Ketik --}}
                    <div class="animate-typing-luka">
                        <span class="font-game text-5xl md:text-6xl text-transparent bg-clip-text bg-gradient-to-r from-[#f43f5e] via-[#f97316] to-[#eab308] drop-shadow-[0_4px_12px_rgba(249,115,22,0.45)] tracking-wider">
                            LUKA
                        </span>
                    </div>
                    {{-- Pembatas/Line vertikal neon yang kontras --}}
                    <div class="w-[3px] h-12 bg-gradient-to-b from-[#f97316] to-[#eab308] rounded-full shadow-[0_0_8px_#f97316] shrink-0"></div>
                    {{-- Sub-branding dengan Efek Ketik Teratur --}}
                    <div class="animate-typing-mentor">
                        <div class="font-game flex flex-col items-start uppercase leading-none">
                            <div class="bg-slate-900 text-white text-[9px] px-2.5 py-1 rounded shadow-[0_2px_4px_rgba(0,0,0,0.15)] tracking-[0.15em] whitespace-nowrap">
                                The Mentor
                            </div>
                            <div class="text-slate-800 text-[13px] tracking-[0.15em] mt-1.5 pl-0.5 whitespace-nowrap">
                                Digital
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================================================== --}}
        {{-- BAGIAN KANAN: Biru Cerah-Gelap + Form Login + Partikel --}}
        {{-- ================================================== --}}
        <div class="w-0 opacity-0 pointer-events-none bg-[#0252b9] text-white rounded-none md:rounded-l-[80px] shadow-[-10px_0_30px_rgba(0,0,0,0.15)] flex items-center justify-center p-4 md:p-8 relative overflow-hidden transition-all duration-[1000ms] ease-in-out" id="particle-container">

            {{-- Form Wrapper (Transparent Content Container) --}}
            <div id="login-form-wrapper" class="w-full max-w-md relative z-20 opacity-0 blur-sm scale-95 pointer-events-none transition-all duration-700">
                {{-- Logo untuk Versi Mobile --}}
                <div class="flex items-center gap-3 mb-8 md:hidden">
                    <img src="{{ asset('img/logo_sekolah.png') }}" class="w-12 h-12 object-contain">
                    <div>
                        <h1 class="text-sm font-black text-white uppercase tracking-widest leading-none">Gamifikasi</h1>
                        <p class="text-[10px] text-blue-200 font-semibold mt-1">PKBM Terang Mulia</p>
                    </div>
                </div>

                <div class="mb-10">
                    <h2 class="text-4xl font-bold text-white mb-2 tracking-tight">Login</h2>
                    <p class="text-blue-100/90 text-sm">Ayo masuk dan mulai berpetualang.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- Input Email --}}
                    <div class="group">
                        <label class="block text-white/80 text-[10px] font-extrabold uppercase tracking-wider mb-2 ml-1">Email Sekolah</label>
                        <div class="relative">
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="w-full px-5 py-4 rounded-2xl bg-[#0149a6] border border-white/10 text-white focus:bg-[#014298] focus:border-white/30 focus:ring-0 placeholder-white/35 transition-all text-sm outline-none shadow-inner"
                                   placeholder="pandu@sekolah.com">
                            <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-blue-200 group-focus-within:text-white text-lg font-semibold transition-colors duration-200">
                                @
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-200 ml-1" />
                    </div>

                    {{-- Input Password --}}
                    <div class="group">
                        <label class="block text-white/80 text-[10px] font-extrabold uppercase tracking-wider mb-2 ml-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" required
                                   class="w-full px-5 py-4 rounded-2xl bg-[#0149a6] border border-white/10 text-white focus:bg-[#014298] focus:border-white/30 focus:ring-0 placeholder-white/35 pr-12 transition-all text-sm outline-none shadow-inner"
                                   placeholder="••••••••">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-5 flex items-center text-blue-200 hover:text-white focus:outline-none transition-colors">
                                <!-- Eye Icon (Show) -->
                                <svg id="eyeIconShow" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <!-- Eye-Slash Icon (Hide) -->
                                <svg id="eyeIconHide" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-200 ml-1" />
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between text-xs text-white/95 px-1">
                        <label class="flex items-center cursor-pointer hover:text-white transition gap-2 select-none">
                            <input type="checkbox" name="remember" class="rounded bg-white/10 border-white/20 text-[#003da1] focus:ring-0 cursor-pointer w-4 h-4">
                            <span class="font-semibold">Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="hover:underline transition font-bold">Lupa Password?</a>
                    </div>

                    {{-- Tombol Login --}}
                    <button type="submit" class="w-full bg-[#003da1] hover:bg-[#003387] text-white font-extrabold py-4 rounded-2xl shadow-lg transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm tracking-widest mt-6">
                        MASUK SEKARANG
                    </button>

                    <div class="text-center mt-8 text-xs text-white/80">
                        Ada masalah login?
                        <a href="#" class="text-white hover:underline font-bold ml-1 transition">Hubungi Guru</a>
                    </div>
                </form>
            </div>

            {{-- Footer Copyright --}}
            <div class="absolute bottom-6 right-8 text-[10px] text-white/45 select-none font-medium z-30">
                &copy; {{ date('Y') }} Gamifikasi System.
            </div>
        </div>

    </div>

    {{-- =============================================== --}}
    {{-- JAVASCRIPT: Parallax & Particles --}}
    {{-- =============================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            let blobs = null;

            // --- BACKROUND SHADER BLUR ANIMATION ---
            const shaderCanvas = document.getElementById('bg-shader');
            if (shaderCanvas) {
                const sCtx = shaderCanvas.getContext('2d');
                let sWidth = shaderCanvas.width = 300;
                let sHeight = shaderCanvas.height = 200;

                blobs = [
                    { x: sWidth * 0.2, y: sHeight * 0.3, vx: 0.5, vy: 0.4, radius: 80, color: 'rgba(2, 82, 185, 0.75)' },   // Royal Blue
                    { x: sWidth * 0.8, y: sHeight * 0.7, vx: -0.4, vy: -0.5, radius: 95, color: 'rgba(56, 189, 248, 0.65)' }, // Sky Blue
                    { x: sWidth * 0.5, y: sHeight * 0.4, vx: 0.3, vy: -0.3, radius: 65, color: 'rgba(255, 255, 255, 0.6)' },  // White
                    { x: sWidth * 0.3, y: sHeight * 0.8, vx: -0.5, vy: 0.4, radius: 85, color: 'rgba(0, 0, 0, 0.95)' },       // Black
                    { x: sWidth * 0.7, y: sHeight * 0.2, vx: 0.4, vy: -0.4, radius: 90, color: 'rgba(15, 23, 42, 0.9)' }       // Dark Slate
                ];

                function resizeShader() {
                    sWidth = shaderCanvas.width = 300;
                    sHeight = shaderCanvas.height = 200;
                }
                window.addEventListener('resize', resizeShader);

                function animateShader() {
                    sCtx.fillStyle = '#050508';
                    sCtx.fillRect(0, 0, sWidth, sHeight);

                    blobs.forEach(blob => {
                        blob.x += blob.vx;
                        blob.y += blob.vy;

                        if (blob.x - blob.radius < -50 || blob.x + blob.radius > sWidth + 50) blob.vx *= -1;
                        if (blob.y - blob.radius < -50 || blob.y + blob.radius > sHeight + 50) blob.vy *= -1;

                        const gradient = sCtx.createRadialGradient(
                            blob.x, blob.y, 0,
                            blob.x, blob.y, blob.radius
                        );
                        gradient.addColorStop(0, blob.color);
                        gradient.addColorStop(1, 'rgba(0, 0, 0, 0)');

                        sCtx.beginPath();
                        sCtx.arc(blob.x, blob.y, blob.radius, 0, Math.PI * 2);
                        sCtx.fillStyle = gradient;
                        sCtx.fill();
                    });

                    requestAnimationFrame(animateShader);
                }
                animateShader();
            }

            // 1. EFEK PARALLAX (Kiri) - Maskot mengikuti Mouse
            const scene = document.getElementById('left-scene');
            const items = document.querySelectorAll('[data-depth]');

            scene.addEventListener('mousemove', (e) => {
                const rect = scene.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width;
                const y = (e.clientY - rect.top) / rect.height;

                items.forEach(item => {
                    const depth = item.getAttribute('data-depth');
                    const moveX = (x - 0.5) * 40 * depth;
                    const moveY = (y - 0.5) * 40 * depth;

                    item.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });
            });

            // 2. EFEK PARTIKEL BUBBLES (Kanan) - Melayang dari bawah ke atas
            const container = document.getElementById('particle-container');
            const particleCount = 20;

            function createParticle() {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                const size = Math.random() * 8 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${Math.random() * 100}%`;

                const duration = Math.random() * 15 + 10;
                particle.style.transition = `bottom ${duration}s linear, opacity ${duration}s ease-in`;
                particle.style.opacity = Math.random() * 0.4;

                container.appendChild(particle);

                setTimeout(() => {
                    particle.style.bottom = '110%';
                    particle.style.opacity = '0';
                }, 100);

                setTimeout(() => {
                    particle.remove();
                    createParticle();
                }, duration * 1000);
            }

            for (let i = 0; i < particleCount; i++) {
                setTimeout(() => {
                    createParticle();
                }, Math.random() * 10000);
            }

            // 3. TOGGLE PASSWORD VISIBILITY
            const togglePasswordBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementsByName('password')[0];
            const eyeIconShow = document.getElementById('eyeIconShow');
            const eyeIconHide = document.getElementById('eyeIconHide');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', () => {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeIconShow.classList.add('hidden');
                        eyeIconHide.classList.remove('hidden');
                    } else {
                        passwordInput.type = 'password';
                        eyeIconShow.classList.remove('hidden');
                        eyeIconHide.classList.add('hidden');
                    }
                });
            }

            // 4. UNLOCK LOGIN INTERACTION (TOGGLE LOCK/UNLOCK)
            window.unlockLogin = function(skipAudio = false) {
                // Play audio unlock effect
                if (!skipAudio) {
                    try {
                        const audio = new Audio("{{ asset('audio/unlock.mp3') }}");
                        audio.play().catch(e => console.log("Sound play blocked by browser policy:", e));
                    } catch (e) {
                        console.warn("Sound play error:", e);
                    }
                }

                // Efek maskot berputar 3D singkat saat diklik
                const desktopMascot = document.getElementById('mascot-img');
                if (desktopMascot) {
                    desktopMascot.classList.remove('animate-spin-once');
                    void desktopMascot.offsetWidth;
                    desktopMascot.classList.add('animate-spin-once');
                }

                // Efek splash pada shader background (mempercepat pergerakan blob sementara)
                if (blobs) {
                    blobs.forEach(blob => {
                        blob.vx *= 3.5;
                        blob.vy *= 3.5;
                    });
                    setTimeout(() => {
                        blobs.forEach(blob => {
                            blob.vx /= 3.5;
                            blob.vy /= 3.5;
                        });
                    }, 1200);
                }

                const loginWrapper = document.getElementById('login-wrapper');
                const leftScene = document.getElementById('left-scene');
                const logoContainer = document.getElementById('logo-container');
                const welcomeText = document.getElementById('welcome-text-container');
                const decorBubbles = document.getElementById('decor-bubbles');
                const particleContainer = document.getElementById('particle-container');
                const formWrapper = document.getElementById('login-form-wrapper');
                const unlockInst = document.getElementById('unlock-instruction');
                const mascotAura = document.getElementById('mascot-aura');
                const leftBranding = document.getElementById('left-branding-container');

                // Deteksi status terkunci
                const isLocked = leftScene.classList.contains('bg-transparent');

                if (isLocked) {
                    // JIKA TERKUNCI -> BUKA KUNCI
                    leftScene.classList.remove('w-full', 'bg-transparent');
                    leftScene.classList.add('w-0', 'md:w-[55%]', 'bg-cream-semi', 'opacity-0', 'md:opacity-100');

                    if (loginWrapper) {
                        loginWrapper.classList.remove('bg-transparent');
                        loginWrapper.classList.add('bg-[#faf9f5]');
                    }

                    if (logoContainer) {
                        logoContainer.classList.remove('opacity-0', 'pointer-events-none');
                        logoContainer.classList.add('opacity-100');
                    }
                    if (welcomeText) {
                        welcomeText.classList.remove('opacity-0', 'translate-y-4');
                        welcomeText.classList.add('opacity-100', 'translate-y-0');
                    }
                    if (decorBubbles) {
                        decorBubbles.classList.remove('opacity-0', 'pointer-events-none');
                        decorBubbles.classList.add('opacity-100');
                    }
                    if (mascotAura) {
                        mascotAura.classList.remove('opacity-0');
                        mascotAura.classList.add('opacity-100');
                    }
                    if (leftBranding) {
                        leftBranding.classList.remove('opacity-0', 'scale-95', 'blur-sm', 'pointer-events-none');
                        leftBranding.classList.add('opacity-100', 'scale-100', 'blur-none');
                    }

                    if (particleContainer) {
                        particleContainer.classList.remove('w-0', 'opacity-0', 'pointer-events-none');
                        particleContainer.classList.add('w-full', 'md:w-[45%]', 'opacity-100', 'pointer-events-auto');
                    }
                    if (formWrapper) {
                        formWrapper.classList.remove('opacity-0', 'blur-sm', 'scale-95', 'pointer-events-none');
                    }
                    if (unlockInst) {
                        unlockInst.classList.add('hidden');
                    }
                } else {
                    // JIKA SUDAH TERBUKA -> KUNCI KEMBALI
                    leftScene.classList.remove('w-0', 'md:w-[55%]', 'bg-cream-semi', 'opacity-0', 'md:opacity-100');
                    leftScene.classList.add('w-full', 'bg-transparent');

                    if (loginWrapper) {
                        loginWrapper.classList.remove('bg-[#faf9f5]');
                        loginWrapper.classList.add('bg-transparent');
                    }

                    if (logoContainer) {
                        logoContainer.classList.remove('opacity-100');
                        logoContainer.classList.add('opacity-0', 'pointer-events-none');
                    }
                    if (welcomeText) {
                        welcomeText.classList.remove('opacity-100', 'translate-y-0');
                        welcomeText.classList.add('opacity-0', 'translate-y-4');
                    }
                    if (decorBubbles) {
                        decorBubbles.classList.add('opacity-0', 'pointer-events-none');
                        decorBubbles.classList.remove('opacity-100');
                    }
                    if (mascotAura) {
                        mascotAura.classList.remove('opacity-100');
                        mascotAura.classList.add('opacity-0');
                    }
                    if (leftBranding) {
                        leftBranding.classList.remove('opacity-100', 'scale-100', 'blur-none');
                        leftBranding.classList.add('opacity-0', 'scale-95', 'blur-sm', 'pointer-events-none');
                    }

                    if (particleContainer) {
                        particleContainer.classList.remove('w-full', 'md:w-[45%]', 'opacity-100', 'pointer-events-auto');
                        particleContainer.classList.add('w-0', 'opacity-0', 'pointer-events-none');
                    }
                    if (formWrapper) {
                        formWrapper.classList.add('opacity-0', 'blur-sm', 'scale-95', 'pointer-events-none');
                    }
                    if (unlockInst) {
                        unlockInst.classList.remove('hidden');
                    }
                }
            };

            // Auto unlock and toast handle on error
            @if ($errors->any())
                // Auto-unlock the login form instantly without sound
                setTimeout(() => {
                    if (typeof window.unlockLogin === 'function') {
                        window.unlockLogin(true);
                    }
                }, 100);

                // Animate error toast slide-in
                setTimeout(() => {
                    const toast = document.getElementById('error-toast');
                    const progress = document.getElementById('toast-progress');
                    if (toast) {
                        toast.classList.remove('translate-x-[120%]');
                        toast.classList.add('translate-x-0');
                    }
                    if (progress) {
                        progress.style.width = '0%';
                    }
                    
                    // Auto dismiss after 5 seconds
                    setTimeout(() => {
                        if (typeof window.dismissToast === 'function') {
                            window.dismissToast();
                        }
                    }, 5000);
                }, 300);
            @endif

            // Declare dismissToast globally
            window.dismissToast = function() {
                const toast = document.getElementById('error-toast');
                if (toast) {
                    toast.classList.remove('translate-x-0');
                    toast.classList.add('translate-x-[120%]');
                    setTimeout(() => {
                        toast.remove();
                    }, 500);
                }
            };
        });
    </script>

</body>
</html>
