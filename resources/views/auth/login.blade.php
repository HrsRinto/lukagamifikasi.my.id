<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Gamifikasi SMP Terang Mulia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Google --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; overflow: hidden; }

        /* --- PERBAIKAN WARNA BACKGROUND --- */
        .bg-navy-deep {
            /* SEBELUMNYA: linear-gradient(135deg, ...); -> Menyebabkan warna tepi kiri berubah-ubah.
               SEKARANG: linear-gradient(to right, ...); -> Membuat tepi kiri warnanya solid #1d4ed8.
            */
            background: linear-gradient(to right, #1d4ed8, #0f172a);
        }

        /* Warna Input Transparan Gelap */
        .input-navy-light {
            background-color: rgba(15, 23, 42, 0.6); /* Semi-transparent dark blue */
            border: 1px solid rgba(59, 130, 246, 0.3); /* Border biru tipis */
        }

        .text-aqua { color: #38bdf8; } /* Sky Blue */

        .btn-aqua {
            background: linear-gradient(to right, #0ea5e9, #2563eb); /* Sky to Blue */
            color: white;
        }
        .btn-aqua:hover {
            background: linear-gradient(to right, #2563eb, #0ea5e9);
            box-shadow: 0 0 20px rgba(14, 165, 233, 0.6);
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
            background: rgba(56, 189, 248, 0.3); /* Biru muda transparan */
            border-radius: 50%;
            pointer-events: none;
            bottom: -50px;
        }

        /* Shadow Maskot Spesial */
        .mascot-glow {
            filter: drop-shadow(0 0 40px rgba(37, 99, 235, 0.7)); /* Bayangan Biru Tebal */
        }
    </style>
</head>
<body class="bg-navy-deep min-h-screen flex items-center justify-center relative">

    <div class="w-full h-screen flex flex-col md:flex-row relative z-10">

        {{-- ================================================== --}}
        {{-- BAGIAN KIRI: Putih/Terang + Maskot Parallax --}}
        {{-- ================================================== --}}
        <div class="w-full md:w-[55%] bg-[#f4f7f6] relative flex items-center justify-center overflow-hidden" id="left-scene">

            {{-- Dekorasi Gelombang (Curve) --}}
            {{-- SVG ini fill-nya #1d4ed8, sekarang akan cocok dengan tepi background kanan --}}
            <div class="absolute top-0 right-[-1px] h-full w-32 md:w-64 z-20 pointer-events-none">
                <svg class="h-full w-full" preserveAspectRatio="none" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 0V100C40 70 40 30 100 0Z" fill="#1d4ed8"/>
                </svg>
            </div>

            {{-- Logo Sekolah (Pojok Kiri Atas) --}}
            <div class="absolute top-8 left-8 flex items-center gap-3 z-30">
                <img src="{{ asset('img/logo_sekolah.png') }}" class="w-12 h-12 object-contain">
                <div>
                    <h1 class="text-sm font-bold text-slate-800 uppercase tracking-widest">Gamifikasi</h1>
                    <p class="text-[10px] text-slate-500 font-semibold">SMP Terang Mulia</p>
                </div>
            </div>

            {{-- Container Parallax --}}
            <div class="relative z-10 p-10 text-center" id="parallax-container">

                {{-- Elemen Dekorasi (Bola-bola melayang di belakang) --}}
                <div data-depth="0.2" class="absolute top-10 left-10 w-20 h-20 bg-blue-300 rounded-full blur-2xl opacity-60"></div>
                <div data-depth="0.5" class="absolute bottom-20 right-40 w-40 h-40 bg-blue-500 rounded-full blur-[80px] opacity-40"></div>
                <div data-depth="0.1" class="absolute top-40 right-10 w-10 h-10 bg-indigo-300 rounded-full opacity-40"></div>

                {{-- MASKOT UTAMA --}}
                <div data-depth="0.3" class="relative group cursor-pointer">

                    {{-- Glow Biru Tambahan di Belakang Maskot --}}
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-blue-500 rounded-full blur-[60px] opacity-50 -z-10"></div>

                    {{-- Bayangan pijakan maskot --}}
                    <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 w-48 h-6 bg-blue-900/20 blur-md rounded-[100%]"></div>

                    <img src="{{ asset('img/maskot.png') }}"
                         class="w-64 md:w-96 object-contain animate-float transform transition-transform duration-100 mascot-glow"
                         alt="Maskot Luka"
                         id="mascot-img">
                </div>

                {{-- Teks Sambutan (Bergerak sedikit) --}}
                <div data-depth="0.1" class="mt-8">
                    <h2 class="text-3xl font-black text-slate-800 mb-1">Siap Berpetualang?</h2>
                    <p class="text-slate-500 font-medium">Masuk dan Gelar Favoritmu!</p>
                </div>
            </div>
        </div>

        {{-- ================================================== --}}
        {{-- BAGIAN KANAN: Biru Cerah-Gelap + Form Login + Partikel --}}
        {{-- ================================================== --}}
        <div class="w-full md:w-[45%] bg-navy-deep flex items-center justify-center p-8 relative overflow-hidden" id="particle-container">

            {{-- Form Wrapper --}}
            <div class="w-full max-w-sm relative z-20">
                <div class="mb-10">
                    <h2 class="text-4xl font-bold text-white mb-2 tracking-tight drop-shadow-md">Login</h2>
                    <p class="text-blue-100 text-sm">Ayo masuk dan mulai berpetualang.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- Input Email --}}
                    <div class="group">
                        <label class="block text-blue-100 text-xs font-bold uppercase mb-2 ml-1">Email Sekolah</label>
                        <div class="relative">
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="w-full px-6 py-4 rounded-2xl input-navy-light text-white border-2 border-transparent focus:border-cyan-400 focus:ring-0 placeholder-blue-300/50 transition-all text-sm outline-none shadow-lg"
                                   placeholder="nama@sekolah.sch.id">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-300 group-focus-within:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-300 ml-1" />
                    </div>

                    {{-- Input Password --}}
                    <div class="group">
                        <label class="block text-blue-100 text-xs font-bold uppercase mb-2 ml-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" required
                                   class="w-full px-6 py-4 rounded-2xl input-navy-light text-white border-2 border-transparent focus:border-cyan-400 focus:ring-0 placeholder-blue-300/50 transition-all text-sm outline-none shadow-lg"
                                   placeholder="Masukkan password">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-300 group-focus-within:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-300 ml-1" />
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between text-xs text-blue-200 px-1">
                        <label class="flex items-center cursor-pointer hover:text-white transition gap-2">
                            <input type="checkbox" name="remember" class="rounded bg-slate-700 border-none text-cyan-500 focus:ring-0 cursor-pointer">
                            <span>Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-aqua hover:text-white transition font-bold">Lupa Password?</a>
                    </div>

                    {{-- Tombol Login --}}
                    <button type="submit" class="w-full btn-aqua font-bold py-4 rounded-2xl shadow-lg shadow-cyan-500/20 transform transition hover:-translate-y-1 hover:shadow-cyan-500/40 text-lg tracking-wide mt-6">
                        MASUK SEKARANG
                    </button>

                    <div class="text-center mt-8">
                        <p class="text-xs text-blue-300">
                            Ada masalah login?
                            <a href="#" class="text-blue-100 hover:text-white font-bold ml-1 transition border-b border-blue-400/50 hover:border-white pb-0.5">Hubungi Guru</a>
                        </p>
                    </div>
                </form>
            </div>

            {{-- Footer Copyright --}}
            <div class="absolute bottom-6 right-8 text-[10px] text-blue-400/70">
                &copy; {{ date('Y') }} Gamifikasi System.
            </div>
        </div>

    </div>

    {{-- =============================================== --}}
    {{-- JAVASCRIPT: Parallax & Particles --}}
    {{-- =============================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // 1. EFEK PARALLAX (Kiri) - Maskot mengikuti Mouse
            const scene = document.getElementById('left-scene');
            const items = document.querySelectorAll('[data-depth]');

            scene.addEventListener('mousemove', (e) => {
                // Mendapatkan posisi mouse relatif terhadap tengah container kiri
                const x = e.clientX / (window.innerWidth * 0.55); // 0.55 karena lebar 55%
                const y = e.clientY / window.innerHeight;

                items.forEach(item => {
                    const depth = item.getAttribute('data-depth');
                    // Kalkulasi pergerakan (semakin besar depth, semakin cepat geraknya)
                    const moveX = (x - 0.5) * 40 * depth;
                    const moveY = (y - 0.5) * 40 * depth;

                    item.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });
            });

            // 2. EFEK PARTIKEL BUBBLES (Kanan) - Melayang dari bawah ke atas
            const container = document.getElementById('particle-container');
            const particleCount = 25; // Jumlah partikel

            // Fungsi membuat 1 partikel
            function createParticle() {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                // Ukuran random (kecil-sedang)
                const size = Math.random() * 8 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;

                // Posisi Horizontal Random
                particle.style.left = `${Math.random() * 100}%`;

                // Durasi animasi random (agar tidak seragam)
                const duration = Math.random() * 15 + 10; // 10s - 25s

                // Set style animasi via JS
                particle.style.transition = `bottom ${duration}s linear, opacity ${duration}s ease-in`;
                particle.style.opacity = Math.random() * 0.5; // Transparansi awal random

                container.appendChild(particle);

                // Trigger animasi setelah render
                setTimeout(() => {
                    particle.style.bottom = '110%'; // Terbang sampai atas layar
                    particle.style.opacity = '0'; // Menghilang pelan-pelan
                }, 100);

                // Hapus dan buat baru setelah selesai
                setTimeout(() => {
                    particle.remove();
                    createParticle();
                }, duration * 1000);
            }

            // Inisialisasi loop partikel
            for (let i = 0; i < particleCount; i++) {
                // Beri delay random awal agar tidak muncul bersamaan
                setTimeout(() => {
                    createParticle();
                }, Math.random() * 10000);
            }
        });
    </script>

</body>
</html>
