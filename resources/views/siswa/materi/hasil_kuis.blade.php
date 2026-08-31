<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Misi - {{ $materi->judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Script untuk Efek Confetti (Hanya jika menang) --}}
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        body { font-family: 'Nunito', sans-serif; }
        @keyframes scaleUp {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-scale { animation: scaleUp 0.5s ease-out forwards; }
        
        .glass-card {
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: float 3s ease-in-out infinite; }

        @keyframes pulseGlow {
            0% { transform: scale(0.95); opacity: 0.4; }
            50% { transform: scale(1.1); opacity: 0.8; }
            100% { transform: scale(0.95); opacity: 0.4; }
        }
        .animate-glow-ring {
            animation: pulseGlow 2.5s ease-in-out infinite;
        }

        @keyframes floatParticle {
            0% { transform: translateY(0px) rotate(0deg); opacity: 0; }
            10% { opacity: 0.4; }
            90% { opacity: 0.4; }
            100% { transform: translateY(-120px) rotate(360deg); opacity: 0; }
        }
        .floating-particle {
            position: absolute;
            pointer-events: none;
            animation: floatParticle 8s infinite linear;
        }

        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 30%;
            height: 200%;
            background: rgba(255, 255, 255, 0.25);
            transform: rotate(30deg);
            transition: all 0.6s ease;
        }
        .btn-shine:hover::after {
            left: 130%;
        }
    </style>
</head>

{{--
    =======================================================
    LOGIKA PENENTUAN STATUS MISI (Berdasarkan Total Skor 30)
    =======================================================
--}}
@php
    // Default Variables
    $status = '';
    $themeColor = '';
    $icon = '';
    $message = '';
    $bgGradient = '';
    $btnColor = '';

    // KONDISI 1: MISI BERHASIL (> 20 Poin)
    if ($nilai > 20) {
        $status = 'MISI BERHASIL';
        $themeColor = 'text-emerald-400';
        $borderColor = 'border-emerald-500';
        $icon = '🏆';
        $message = 'Luar biasa! Kamu telah menaklukkan tantangan ini dengan gemilang.';
        $bgGradient = 'from-emerald-950 to-slate-950';
        $btnColor = 'bg-emerald-600 hover:bg-emerald-500 shadow-emerald-500/30';
        $cardGlow = 'border-emerald-500/30 shadow-[0_20px_50px_rgba(16,185,129,0.25)]';
        $isWin = true;
    }
    // KONDISI 2: AYO BERUSAHA LAGI (11 - 20 Poin)
    elseif ($nilai >= 11 && $nilai <= 20) {
        $status = 'AYO BERUSAHA LAGI';
        $themeColor = 'text-blue-400';
        $borderColor = 'border-blue-500';
        $icon = '🔥';
        $message = 'Kamu sudah di jalan yang benar, tapi butuh sedikit lagi latihan!';
        $bgGradient = 'from-blue-950 to-slate-950';
        $btnColor = 'bg-blue-600 hover:bg-blue-500 shadow-blue-500/30';
        $cardGlow = 'border-blue-500/30 shadow-[0_20px_50px_rgba(59,130,246,0.25)]';
        $isWin = false;
    }
    // KONDISI 3: MISI GAGAL (1 - 10 Poin atau 0)
    else {
        $status = 'MISI GAGAL';
        $themeColor = 'text-red-500';
        $borderColor = 'border-red-600';
        $icon = '💀';
        $message = 'Jangan menyerah. Pelajari materi sekali lagi dan kembali lebih kuat!';
        $bgGradient = 'from-red-950 to-slate-950';
        $btnColor = 'bg-red-600 hover:bg-red-500 shadow-red-500/30';
        $cardGlow = 'border-red-500/30 shadow-[0_20px_50px_rgba(239,68,68,0.2)]';
        $isWin = false;
    }
@endphp

<body class="min-h-screen flex items-center justify-center py-12 px-4 relative overflow-x-hidden bg-gradient-to-br {{ $bgGradient }}">

    {{-- Floating Particles / Stars --}}
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="floating-particle text-emerald-400/20 text-3xl" style="top: 20%; left: 10%; animation-delay: 0s; animation-duration: 6s;">★</div>
        <div class="floating-particle text-yellow-400/20 text-2xl" style="top: 60%; left: 85%; animation-delay: 2s; animation-duration: 9s;">✦</div>
        <div class="floating-particle text-blue-400/20 text-4xl" style="top: 80%; left: 15%; animation-delay: 4s; animation-duration: 7s;">✧</div>
        <div class="floating-particle text-indigo-400/20 text-xl" style="top: 15%; left: 80%; animation-delay: 1s; animation-duration: 8s;">★</div>
        <div class="floating-particle text-pink-400/20 text-2xl" style="top: 40%; left: 75%; animation-delay: 3s; animation-duration: 10s;">✦</div>
    </div>

    {{-- DEKORASI BACKGROUND (Dinamis sesuai hasil) --}}
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute top-[-20%] left-1/2 -translate-x-1/2 w-[600px] h-[600px] {{ $nilai > 20 ? 'bg-emerald-500/20' : ($nilai >= 11 ? 'bg-blue-500/20' : 'bg-red-600/10') }} rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
    </div>

    {{-- CARD UTAMA --}}
    <div class="relative z-10 w-full max-w-xl glass-card rounded-[2.5rem] {{ $cardGlow }} border border-white/10 overflow-hidden text-center animate-scale p-8 md:p-14">

        {{-- 1. ICON & NILAI --}}
        <div class="mb-10 relative mt-4 animate-float">
            {{-- Glowing Rings behind --}}
            <div class="absolute inset-0 w-44 h-44 md:w-56 md:h-56 mx-auto rounded-full bg-gradient-to-tr {{ $nilai > 20 ? 'from-emerald-500/30 to-teal-500/30' : ($nilai >= 11 ? 'from-blue-500/30 to-indigo-500/30' : 'from-red-500/20 to-rose-500/20') }} blur-xl animate-glow-ring"></div>
            
            {{-- Lingkaran Luar --}}
            <div class="w-44 h-44 md:w-56 md:h-56 mx-auto rounded-full flex items-center justify-center border-[6px] md:border-[8px] {{ $borderColor }} shadow-[0_0_40px_rgba(0,0,0,0.5)] bg-slate-900 relative">

                {{-- Icon Besar --}}
                <span class="text-6xl md:text-8xl filter drop-shadow-lg transform hover:scale-125 hover:rotate-12 transition duration-500 cursor-default">
                    {{ $icon }}
                </span>

                {{-- Badge Nilai (Floating di bawah) --}}
                <div class="absolute -bottom-5 left-1/2 -translate-x-1/2 bg-slate-800 text-white px-8 py-2.5 rounded-full font-black text-2xl md:text-3xl shadow-xl border-2 {{ $borderColor }} min-w-[120px] md:min-w-[150px]">
                    {{ $nilai }} <span class="text-xs md:text-sm text-gray-400 font-normal">/30</span>
                </div>
            </div>
        </div>

        {{-- 2. TEXT STATUS --}}
        <div class="mb-10 mt-12">
            <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tight {{ $themeColor }} mb-4 drop-shadow-sm">
                {{ $status }}
            </h2>
            <p class="text-slate-200 text-sm md:text-lg font-medium px-2 leading-relaxed">
                {{ $message }}
            </p>
        </div>

        {{-- 3. REWARD BOX (Total Score Info) --}}
        <div class="bg-black/30 rounded-2xl p-5 mb-10 border border-white/5 flex justify-between items-center px-8">
            <div class="text-left">
                <span class="block text-[10px] md:text-xs text-gray-500 font-bold uppercase tracking-widest">Tingkat Kesulitan</span>
                <span class="text-white font-bold text-sm md:text-base">Mixed (Easy-Hard)</span>
            </div>
            <div class="text-right">
                <span class="block text-[10px] md:text-xs text-gray-500 font-bold uppercase tracking-widest">Total Skor</span>
                <span class="block text-xl md:text-2xl font-black text-white">{{ $nilai }} Poin</span>
            </div>
        </div>

        {{-- 4. TOMBOL AKSI --}}
        <div class="space-y-4">
            {{-- Tombol Utama (Warna sesuai hasil) --}}
            <a href="{{ route('siswa.dashboard') }}" class="btn-shine block w-full py-4 md:py-5 rounded-2xl font-bold text-white text-base md:text-lg shadow-lg transition duration-300 transform hover:-translate-y-1 hover:scale-[1.02] hover:shadow-xl {{ $btnColor }}">
                Kembali ke Markas
            </a>

            {{-- Tombol Sekunder --}}
            <a href="{{ route('siswa.leaderboard') }}" class="block w-full py-4 md:py-5 rounded-2xl border border-white/10 text-slate-300 font-bold hover:bg-white/5 hover:text-white text-base md:text-lg transition duration-300 transform hover:-translate-y-0.5 hover:scale-[1.02] hover:border-white/20">
                Cek Peringkat Kelas
            </a>
        </div>

    </div>

    {{-- SCRIPT EFEK CONFETTI --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($isWin) && $isWin)
                // Konfeti Terus Menerus jika Misi Berhasil (> 20 Poin)
                var duration = 3 * 1000;
                var animationEnd = Date.now() + duration;
                var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

                function randomInRange(min, max) { return Math.random() * (max - min) + min; }

                var interval = setInterval(function() {
                  var timeLeft = animationEnd - Date.now();
                  if (timeLeft <= 0) { return clearInterval(interval); }
                  var particleCount = 50 * (timeLeft / duration);

                  confetti(Object.assign({}, defaults, {
                      particleCount,
                      origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 },
                      colors: ['#34d399', '#fbbf24', '#ffffff'] // Hijau, Emas, Putih
                  }));
                  confetti(Object.assign({}, defaults, {
                      particleCount,
                      origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 },
                      colors: ['#34d399', '#fbbf24', '#ffffff']
                  }));
                }, 250);
            @elseif($nilai >= 11 && $nilai <= 20)
                // Blast konfeti sekali untuk motivasi Ayo Berusaha Lagi
                confetti({
                    particleCount: 80,
                    spread: 70,
                    origin: { y: 0.6 },
                    colors: ['#60a5fa', '#3b82f6', '#ffffff'] // Biru & Putih
                });
            @endif
        });
    </script>

</body>
</html>
