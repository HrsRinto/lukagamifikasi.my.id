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
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
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
        $bgGradient = 'from-emerald-900 to-slate-900';
        $btnColor = 'bg-emerald-600 hover:bg-emerald-500 shadow-emerald-500/30';
        $isWin = true;
    }
    // KONDISI 2: AYO BERUSAHA LAGI (11 - 20 Poin)
    elseif ($nilai >= 11 && $nilai <= 20) {
        $status = 'AYO BERUSAHA LAGI';
        $themeColor = 'text-blue-400';
        $borderColor = 'border-blue-500';
        $icon = '🔥';
        $message = 'Kamu sudah di jalan yang benar, tapi butuh sedikit lagi latihan!';
        $bgGradient = 'from-blue-900 to-slate-900';
        $btnColor = 'bg-blue-600 hover:bg-blue-500 shadow-blue-500/30';
        $isWin = false;
    }
    // KONDISI 3: MISI GAGAL (1 - 10 Poin atau 0)
    else {
        $status = 'MISI GAGAL';
        $themeColor = 'text-red-500';
        $borderColor = 'border-red-600';
        $icon = '💀';
        $message = 'Jangan menyerah. Pelajari materi sekali lagi dan kembali lebih kuat!';
        $bgGradient = 'from-red-950 to-slate-900';
        $btnColor = 'bg-red-600 hover:bg-red-500 shadow-red-500/30';
        $isWin = false;
    }
@endphp

<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden bg-gradient-to-br {{ $bgGradient }}">

    {{-- DEKORASI BACKGROUND (Dinamis sesuai hasil) --}}
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute top-[-20%] left-1/2 -translate-x-1/2 w-[600px] h-[600px] {{ $nilai > 20 ? 'bg-emerald-500/20' : ($nilai >= 11 ? 'bg-blue-500/20' : 'bg-red-600/10') }} rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
    </div>

    {{-- CARD UTAMA --}}
    <div class="relative z-10 w-full max-w-md glass-card rounded-[3rem] shadow-2xl overflow-hidden text-center animate-scale p-8">

        {{-- 1. ICON & NILAI --}}
        <div class="mb-8 relative mt-4">
            {{-- Lingkaran Luar --}}
            <div class="w-40 h-40 mx-auto rounded-full flex items-center justify-center border-[6px] {{ $borderColor }} shadow-[0_0_40px_rgba(0,0,0,0.5)] bg-slate-900 relative">

                {{-- Icon Besar --}}
                <span class="text-6xl filter drop-shadow-lg transform hover:scale-110 transition duration-300 cursor-default">
                    {{ $icon }}
                </span>

                {{-- Badge Nilai (Floating di bawah) --}}
                <div class="absolute -bottom-5 left-1/2 -translate-x-1/2 bg-slate-800 text-white px-6 py-2 rounded-full font-black text-2xl shadow-xl border-2 {{ $borderColor }} min-w-[100px]">
                    {{ $nilai }} <span class="text-xs text-gray-400 font-normal">/30</span>
                </div>
            </div>
        </div>

        {{-- 2. TEXT STATUS --}}
        <div class="mb-8 mt-8">
            <h2 class="text-3xl font-black uppercase tracking-tight {{ $themeColor }} mb-3 drop-shadow-sm">
                {{ $status }}
            </h2>
            <p class="text-slate-300 text-sm font-medium px-2 leading-relaxed">
                {{ $message }}
            </p>
        </div>

        {{-- 3. REWARD BOX (Total Score Info) --}}
        <div class="bg-black/30 rounded-2xl p-4 mb-8 border border-white/5 flex justify-between items-center px-6">
            <div class="text-left">
                <span class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest">Tingkat Kesulitan</span>
                <span class="text-white font-bold text-sm">Mixed (Easy-Hard)</span>
            </div>
            <div class="text-right">
                <span class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest">Total Skor</span>
                <span class="block text-xl font-black text-white">{{ $nilai }} Poin</span>
            </div>
        </div>

        {{-- 4. TOMBOL AKSI --}}
        <div class="space-y-3">
            {{-- Tombol Utama (Warna sesuai hasil) --}}
            <a href="{{ route('siswa.dashboard') }}" class="block w-full py-4 rounded-2xl font-bold text-white shadow-lg transition transform hover:-translate-y-1 hover:shadow-xl {{ $btnColor }}">
                Kembali ke Markas
            </a>

            {{-- Tombol Sekunder --}}
            <a href="{{ route('siswa.leaderboard') }}" class="block w-full py-4 rounded-2xl border border-white/10 text-slate-300 font-bold hover:bg-white/5 hover:text-white transition">
                Cek Peringkat Kelas
            </a>
        </div>

    </div>

    {{-- SCRIPT EFEK CONFETTI (Hanya jika Misi Berhasil > 20) --}}
    @if(isset($isWin) && $isWin)
    <script>
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
    </script>
    @endif

</body>
</html>
