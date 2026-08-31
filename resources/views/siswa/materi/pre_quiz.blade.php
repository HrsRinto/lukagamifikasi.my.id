<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peraturan Kuis - {{ $materi->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
        .font-game {
            font-family: 'Lilita One', cursive;
        }
        .font-tech {
            font-family: 'Space Grotesk', sans-serif;
        }

        /* --- FLOATING BUBBLES ANIMATION --- */
        @keyframes float-bubble {
            0% {
                transform: translateY(115vh) scale(0.7) rotate(0deg);
                opacity: 0;
            }
            15% {
                opacity: 0.25;
            }
            85% {
                opacity: 0.25;
            }
            100% {
                transform: translateY(-15vh) scale(1.3) rotate(360deg);
                opacity: 0;
            }
        }
        
        .bubble {
            position: absolute;
            bottom: -150px;
            background: linear-gradient(135deg, rgba(2, 82, 185, 0.12), rgba(14, 165, 233, 0.05));
            border: 1.5px solid rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            pointer-events: none;
            box-shadow: inset 0 5px 15px rgba(255, 255, 255, 0.4), 0 8px 20px rgba(2, 82, 185, 0.03);
            animation: float-bubble 15s infinite linear;
        }

        /* --- AURA MOVEMENT --- */
        @keyframes aura-movement {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(40px, -60px) scale(1.15);
            }
            66% {
                transform: translate(-30px, 30px) scale(0.9);
            }
        }
        .animate-aura-slow-1 {
            animation: aura-movement 16s infinite ease-in-out;
        }
        .animate-aura-slow-2 {
            animation: aura-movement 22s infinite ease-in-out reverse;
        }
    </style>
</head>
<body class="bg-[#faf9f5] min-h-screen flex items-center justify-center p-3 relative overflow-hidden">

    {{-- BACKGROUND DEKORASI DENGAN AURA GRADASI DAN BUBBLE MELAYANG --}}
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        {{-- Aura Terang --}}
        <div class="absolute top-[-20%] left-[-20%] w-[500px] h-[500px] bg-blue-300/30 rounded-full filter blur-[100px] animate-aura-slow-1"></div>
        <div class="absolute bottom-[-20%] right-[-20%] w-[500px] h-[500px] bg-indigo-300/25 rounded-full filter blur-[100px] animate-aura-slow-2"></div>
        
        {{-- Bubbles --}}
        <div class="bubble w-16 h-16 left-[8%]" style="animation-duration: 18s; animation-delay: 0s;"></div>
        <div class="bubble w-24 h-24 left-[22%]" style="animation-duration: 22s; animation-delay: 2s;"></div>
        <div class="bubble w-12 h-12 left-[38%]" style="animation-duration: 14s; animation-delay: 5s;"></div>
        <div class="bubble w-28 h-28 left-[55%]" style="animation-duration: 26s; animation-delay: 1s;"></div>
        <div class="bubble w-20 h-20 left-[72%]" style="animation-duration: 20s; animation-delay: 4s;"></div>
        <div class="bubble w-14 h-14 left-[88%]" style="animation-duration: 16s; animation-delay: 7s;"></div>
    </div>

    {{-- CARD UTAMA RINGKAS (COMPACT LAYOUT) --}}
    <div class="relative z-10 w-full max-w-xl bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(2,82,185,0.06)] overflow-hidden border border-slate-100 ring-1 ring-black/5 transition-all duration-300">

        {{-- HEADER RINGKAS HORIZONTAL --}}
        <div class="bg-gradient-to-br from-[#0252b9] via-[#0ea5e9] to-[#4f46e5] py-5 px-6 relative overflow-hidden">
            {{-- Grid Pattern Overlay --}}
            <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:15px_15px]"></div>
            
            <div class="relative z-10 flex items-center gap-4 text-left">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl flex items-center justify-center text-2xl shadow-[0_8px_32px_rgba(0,0,0,0.1)] transform hover:scale-105 transition duration-300 shrink-0">
                    ⚡
                </div>
                <div class="overflow-hidden">
                    <h1 class="font-game text-xl md:text-2xl text-white tracking-wide drop-shadow-[0_1px_3px_rgba(0,0,0,0.15)] leading-tight truncate">
                        {{ $materi->title }}
                    </h1>
                    <p class="font-tech text-cyan-200 text-[9px] font-bold uppercase tracking-[0.2em] mt-0.5">Persiapan Kuis Gamifikasi</p>
                </div>
            </div>
        </div>

        {{-- BODY RINGKAS --}}
        <div class="p-5 md:p-7">
            <h3 class="font-game text-center text-slate-800 text-lg mb-5 flex items-center justify-center gap-2">
                <span class="text-amber-500 animate-bounce text-sm">⚠️</span> Baca Aturan Main Dulu Ya!
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Rule 1: Komposisi Soal --}}
                <div class="group flex items-start gap-3 p-3.5 rounded-2xl bg-blue-50/50 border border-blue-100/50 hover:bg-white hover:border-blue-300 hover:shadow-[0_8px_20px_rgba(2,82,185,0.04)] transition-all duration-300">
                    <div class="flex-shrink-0 w-9 h-9 bg-gradient-to-tr from-blue-600 to-cyan-500 text-white rounded-xl flex items-center justify-center font-game text-sm shadow-[0_3px_8px_rgba(2,82,185,0.15)]">
                        15
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-tech font-bold text-slate-800 text-xs uppercase tracking-wider">Total Soal</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed font-medium">Kuis ini terdiri dari 15 butir soal pilihan ganda.</p>
                    </div>
                </div>

                {{-- Rule 2: Tingkat Kesulitan --}}
                <div class="group flex items-start gap-3 p-3.5 rounded-2xl bg-purple-50/50 border border-purple-100/50 hover:bg-white hover:border-purple-300 hover:shadow-[0_8px_20px_rgba(168,85,247,0.04)] transition-all duration-300">
                    <div class="flex-shrink-0 w-9 h-9 bg-gradient-to-tr from-purple-600 to-pink-500 text-white rounded-xl flex items-center justify-center text-sm shadow-[0_3px_8px_rgba(168,85,247,0.15)]">
                        📊
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-tech font-bold text-slate-800 text-xs uppercase tracking-wider">3 Level</h4>
                        <p class="text-[11px] text-slate-500 mt-1 leading-relaxed font-medium">
                            <span class="font-bold text-green-600 bg-green-50 px-1.5 py-0.5 rounded-full text-[10px]">5 Easy</span>
                            <span class="font-bold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-full text-[10px] ml-0.5">5 Med</span>
                            <span class="font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded-full text-[10px] ml-0.5">5 Hard</span>
                        </p>
                    </div>
                </div>

                {{-- Rule 3: Durasi Waktu --}}
                <div class="group flex items-start gap-3 p-3.5 rounded-2xl bg-amber-50/50 border border-amber-100/50 hover:bg-white hover:border-amber-300 hover:shadow-[0_8px_20px_rgba(245,158,11,0.04)] transition-all duration-300">
                    <div class="flex-shrink-0 w-9 h-9 bg-gradient-to-tr from-amber-500 to-orange-400 text-white rounded-xl flex items-center justify-center text-sm shadow-[0_3px_8px_rgba(245,158,11,0.15)]">
                        ⏳
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-tech font-bold text-slate-800 text-xs uppercase tracking-wider">1 Menit / Soal</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed font-medium">Fokus! Jika waktu habis, lanjut otomatis ke soal berikutnya.</p>
                    </div>
                </div>

                {{-- Rule 4: Kunci Jawaban --}}
                <div class="group flex items-start gap-3 p-3.5 rounded-2xl bg-rose-50/50 border border-rose-100/50 hover:bg-white hover:border-rose-300 hover:shadow-[0_8px_20px_rgba(244,63,94,0.04)] transition-all duration-300">
                    <div class="flex-shrink-0 w-9 h-9 bg-gradient-to-tr from-rose-500 to-red-400 text-white rounded-xl flex items-center justify-center text-sm shadow-[0_3px_8px_rgba(244,63,94,0.15)]">
                        🔒
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-tech font-bold text-slate-800 text-xs uppercase tracking-wider">Tidak Bisa Kembali</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed font-medium">Jawaban yang sudah dipilih <span class="font-bold text-rose-600 bg-rose-50 px-1 py-0.5 rounded">tidak dapat diganti</span>.</p>
                    </div>
                </div>

            </div>

            {{-- MOTIVASI BOX RINGKAS --}}
            <div class="mt-5 bg-gradient-to-r from-amber-500/10 to-transparent border border-amber-300/30 rounded-2xl p-4 flex items-center gap-4 relative overflow-hidden shadow-[0_4px_12px_rgba(249,115,22,0.02)]">
                <div class="text-3xl filter drop-shadow-[0_2px_4px_rgba(0,0,0,0.05)] flex-shrink-0 animate-bounce">
                    🐵
                </div>
                <div>
                    <h5 class="font-game text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-orange-500 text-xs uppercase tracking-wider">Pesan dari LUKA:</h5>
                    <p class="text-slate-700 text-xs font-medium italic mt-0.5 leading-relaxed">"Jangan takut salah, takutlah jika tidak mencoba. Semangat mengejar asetmu!!"</p>
                </div>
            </div>

            {{-- TOMBOL AKSI SEJAJAR --}}
            <div class="mt-6 flex gap-3 justify-center">
                {{-- Tombol Batal --}}
                <a href="{{ route('siswa.dashboard') }}" class="flex-1 max-w-[120px] px-4 py-3 rounded-xl border border-slate-200 text-slate-500 font-bold hover:bg-slate-50 hover:text-slate-800 transition duration-300 text-center text-xs flex items-center justify-center">
                    Kembali
                </a>

                {{-- Tombol Mulai --}}
                <a href="{{ route('siswa.kuis.show', $materi->id) }}" class="flex-1 font-tech px-6 py-3 rounded-xl bg-gradient-to-r from-[#0252b9] to-indigo-600 text-white font-bold shadow-[0_4px_15px_rgba(2,82,185,0.2)] hover:shadow-[0_6px_20px_rgba(2,82,185,0.35)] hover:-translate-y-0.5 transition duration-300 text-center text-xs flex items-center justify-center gap-1.5 tracking-wide uppercase">
                    <span>Mulai Kerjakan Sekarang</span>
                    <svg class="w-4 h-4 animate-pulse shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </a>
            </div>

        </div>
    </div>

</body>
</html>
