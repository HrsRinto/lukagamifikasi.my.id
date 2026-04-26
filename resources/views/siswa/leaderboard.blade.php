<x-app-layout>
    {{-- Kita kosongkan slot header bawaan agar tidak merusak desain full-page --}}

    {{-- 1. IMPORT LIBRARY CONFETTI (Ringan & Cepat) --}}
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    {{-- WRAPPER UTAMA: Background Modern Gelap --}}
    <div class="min-h-screen bg-[#020617] relative overflow-hidden font-sans text-gray-100">

        {{-- ================================================== --}}
        {{-- BACKGROUND ANIMASI "AURORA BOREALIS" --}}
        {{-- ================================================== --}}

        {{-- Style Khusus untuk Animasi Blob --}}
        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob {
                animation: blob 7s infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>

        {{-- Layer 1: Base Gradient --}}
        <div class="fixed inset-0 bg-gradient-to-br from-slate-900 via-slate-900 to-indigo-950 z-0"></div>

        {{-- Layer 2: Animated Blobs (Bola Warna Warni) --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0 opacity-40">
            {{-- Blob Ungu (Kiri Atas) --}}
            <div class="absolute top-0 left-[-10%] w-[500px] h-[500px] bg-purple-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-70 animate-blob"></div>

            {{-- Blob Cyan/Biru (Kanan Atas) --}}
            <div class="absolute top-0 right-[-10%] w-[500px] h-[500px] bg-cyan-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-70 animate-blob animation-delay-2000"></div>

            {{-- Blob Pink/Magenta (Bawah Tengah) --}}
            <div class="absolute -bottom-32 left-[20%] w-[500px] h-[500px] bg-pink-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-70 animate-blob animation-delay-4000"></div>
        </div>

        {{-- Layer 3: Noise Texture & Grid --}}
        <div class="fixed inset-0 z-0 opacity-[0.05]" style="background-image: url('https://www.transparenttextures.com/patterns/stardust.png');"></div>
        <div class="fixed inset-0 z-0 opacity-[0.03]" style="background-image: linear-gradient(#ffffff 1px, transparent 1px), linear-gradient(90deg, #ffffff 1px, transparent 1px); background-size: 50px 50px;"></div>

        {{-- ================================================== --}}

        <div class="relative z-10 max-w-4xl mx-auto">

            {{-- 1. HEADER NAVIGASI --}}
            <div class="px-6 pt-8 pb-4 flex justify-between items-center text-white">
                <div>
                    <h2 class="text-3xl font-black tracking-tight drop-shadow-md bg-clip-text text-transparent bg-gradient-to-r from-cyan-300 to-blue-300">
                        Leaderboard
                    </h2>
                    <p class="text-slate-300 text-sm font-medium tracking-wide">SMP Terang Mulia</p>
                </div>
                <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/5 hover:bg-white/10 backdrop-blur-md transition border border-white/10 text-sm font-bold text-slate-200 hover:text-white shadow-lg group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
                    Kembali
                </a>
            </div>

            {{-- 2. PODIUM AREA (EMAS - PERAK - PERUNGGU) --}}
            <div class="pt-8 pb-16 px-4">
                <div class="flex items-end justify-center gap-4 md:gap-8">

                    {{-- === JUARA 2 (PERAK / SILVER) === --}}
                    @if(isset($leaderboard[1]))
                    <div class="flex flex-col items-center w-1/3 max-w-[140px] relative top-4">
                        <div class="relative group">
                            {{-- Glow Effect --}}
                            <div class="absolute inset-0 bg-gray-400 rounded-full blur-xl opacity-20 group-hover:opacity-50 transition-opacity duration-500"></div>

                            <div class="w-20 h-20 md:w-24 md:h-24 rounded-full p-1 bg-gradient-to-b from-gray-300 to-gray-600 shadow-2xl relative z-10">
                                <div class="w-full h-full rounded-full bg-[#1e293b] flex items-center justify-center overflow-hidden border-2 border-gray-400">
                                    @if($leaderboard[1]->profile_photo_path)
                                        <img src="{{ asset('storage/' . $leaderboard[1]->profile_photo_path) }}" class="w-full h-full object-cover" alt="Foto Profil">
                                    @else
                                        <span class="text-2xl font-bold text-gray-300">{{ strtoupper(substr($leaderboard[1]->name, 0, 2)) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-gray-200 border-2 border-[#1e293b] flex items-center justify-center text-gray-800 font-black shadow-lg z-20">2</div>
                            <img src="{{ $leaderboard[1]->badge_image }}" class="absolute -bottom-2 -right-2 w-8 h-8 z-30 drop-shadow-md" alt="Rank">
                        </div>

                        <div class="text-center mt-5 mb-2">
                            <h3 class="text-white font-bold text-sm md:text-base truncate w-28 md:w-32 mx-auto drop-shadow-sm">{{ $leaderboard[1]->name }}</h3>
                            <p class="text-gray-300 font-bold text-xs bg-white/10 px-2 py-0.5 rounded-full inline-block">{{ number_format($leaderboard[1]->points) }} Pts</p>
                        </div>

                        {{-- Tiang Podium Silver --}}
                        <div class="w-full h-24 bg-gradient-to-b from-gray-700/60 to-transparent backdrop-blur-sm rounded-t-xl border-t border-gray-500/30 shadow-[0_-5px_20px_rgba(255,255,255,0.05)]"></div>
                    </div>
                    @endif

                    {{-- === JUARA 1 (EMAS / GOLD) === --}}
                    @if(isset($leaderboard[0]))
                    <div class="flex flex-col items-center w-1/3 max-w-[160px] z-30 -mx-2">
                        <div class="mb-3 animate-bounce">
                           <svg width="56" height="56" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-[0_0_25px_rgba(250,204,21,0.6)]">
                                <path d="M5 16L3 5L8.5 10L12 4L15.5 10L21 5L19 16H5Z" fill="#FACC15" stroke="#EAB308" stroke-width="1.5" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        <div class="relative group">
                            {{-- Glow Effect Gold --}}
                            <div class="absolute inset-0 bg-yellow-500 rounded-full blur-2xl opacity-40 group-hover:opacity-60 transition-opacity duration-500 animate-pulse"></div>

                            <div class="w-28 h-28 md:w-32 md:h-32 rounded-full p-1.5 bg-gradient-to-b from-yellow-200 via-yellow-400 to-yellow-700 shadow-2xl relative z-10 transform group-hover:scale-105 transition-transform duration-300">
                                <div class="w-full h-full rounded-full bg-[#1e293b] flex items-center justify-center overflow-hidden border-4 border-yellow-600">
                                    @if($leaderboard[0]->profile_photo_path)
                                        <img src="{{ asset('storage/' . $leaderboard[0]->profile_photo_path) }}" class="w-full h-full object-cover" alt="Foto Profil">
                                    @else
                                        <span class="text-4xl font-bold text-yellow-400">{{ strtoupper(substr($leaderboard[0]->name, 0, 2)) }}</span>
                                    @endif
                                </div>
                            </div>
                             <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-10 h-10 rounded-full bg-yellow-400 border-4 border-[#1e293b] flex items-center justify-center text-yellow-900 font-black text-lg shadow-xl z-20">1</div>
                             <img src="{{ $leaderboard[0]->badge_image }}" class="absolute -bottom-2 -right-2 w-12 h-12 z-30 drop-shadow-lg transform rotate-12" alt="Rank">
                        </div>

                        <div class="text-center mt-6 mb-2">
                            <h3 class="text-white font-black text-lg truncate w-32 md:w-40 mx-auto drop-shadow-md tracking-wide">{{ $leaderboard[0]->name }}</h3>
                            <p class="text-yellow-400 font-extrabold text-xl drop-shadow-sm">{{ number_format($leaderboard[0]->points) }} Pts</p>
                        </div>

                        {{-- Tiang Podium Gold --}}
                        <div class="w-full h-40 bg-gradient-to-b from-yellow-600/40 to-transparent backdrop-blur-md rounded-t-2xl border-t border-yellow-400/40 relative overflow-hidden shadow-[0_-10px_30px_rgba(234,179,8,0.2)]">
                            <div class="absolute inset-0 bg-yellow-300/10 skew-y-12 transform -translate-y-20"></div> {{-- Kilau --}}
                        </div>
                    </div>
                    @endif

                    {{-- === JUARA 3 (PERUNGGU / BRONZE) === --}}
                    @if(isset($leaderboard[2]))
                    <div class="flex flex-col items-center w-1/3 max-w-[140px] relative top-8">
                         <div class="relative group">
                            {{-- Glow Effect Bronze --}}
                            <div class="absolute inset-0 bg-orange-600 rounded-full blur-xl opacity-20 group-hover:opacity-50 transition-opacity duration-500"></div>

                            <div class="w-20 h-20 md:w-24 md:h-24 rounded-full p-1 bg-gradient-to-b from-orange-300 to-orange-800 shadow-2xl relative z-10">
                                <div class="w-full h-full rounded-full bg-[#1e293b] flex items-center justify-center overflow-hidden border-2 border-orange-700">
                                    @if($leaderboard[2]->profile_photo_path)
                                        <img src="{{ asset('storage/' . $leaderboard[2]->profile_photo_path) }}" class="w-full h-full object-cover" alt="Foto Profil">
                                    @else
                                        <span class="text-2xl font-bold text-orange-400">{{ strtoupper(substr($leaderboard[2]->name, 0, 2)) }}</span>
                                    @endif
                                </div>
                            </div>
                             <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-orange-500 border-2 border-[#1e293b] flex items-center justify-center text-white font-black shadow-lg z-20">3</div>
                            <img src="{{ $leaderboard[2]->badge_image }}" class="absolute -bottom-2 -right-2 w-8 h-8 z-30 drop-shadow-md" alt="Rank">
                        </div>

                        <div class="text-center mt-5 mb-2">
                            <h3 class="text-white font-bold text-sm md:text-base truncate w-28 md:w-32 mx-auto drop-shadow-sm">{{ $leaderboard[2]->name }}</h3>
                            <p class="text-orange-300 font-bold text-xs bg-white/10 px-2 py-0.5 rounded-full inline-block">{{ number_format($leaderboard[2]->points) }} Pts</p>
                        </div>

                        {{-- Tiang Podium Bronze --}}
                        <div class="w-full h-20 bg-gradient-to-b from-orange-800/50 to-transparent backdrop-blur-sm rounded-t-xl border-t border-orange-500/30 shadow-[0_-5px_20px_rgba(249,115,22,0.1)]"></div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- 3. DAFTAR PERINGKAT BAWAH (CARD SLIDE UP) --}}
            <div class="bg-white/95 backdrop-blur-xl rounded-t-[40px] min-h-[500px] px-6 py-8 shadow-[0_-15px_60px_rgba(0,0,0,0.5)] relative z-20 border-t border-white/20">

                {{-- Indikator Slide --}}
                <div class="w-16 h-1.5 bg-gray-300 rounded-full mx-auto mb-8 opacity-50"></div>

                <div class="space-y-4">
                    @forelse($leaderboard->slice(3) as $s)
                        @php $rank = $loop->iteration + 3; @endphp

                        <div class="flex items-center justify-between p-4 rounded-2xl border border-gray-100 shadow-sm transition hover:shadow-lg hover:scale-[1.01] bg-white group hover:border-cyan-300 {{ $s->id == Auth::id() ? 'ring-2 ring-cyan-500 bg-cyan-50' : '' }}">

                            <div class="flex items-center gap-4 overflow-hidden">
                                <span class="font-black text-gray-300 w-8 text-center text-xl group-hover:text-cyan-600 transition-colors">{{ $rank }}</span>

                                <div class="relative flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center overflow-hidden border border-gray-200 group-hover:border-cyan-400 transition-colors">
                                        @if($s->profile_photo_path)
                                            <img src="{{ asset('storage/' . $s->profile_photo_path) }}" class="w-full h-full object-cover" alt="Foto Profil">
                                        @else
                                            <span class="text-slate-500 font-bold text-lg">{{ strtoupper(substr($s->name, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <img src="{{ $s->badge_image }}" class="absolute -bottom-1 -right-1 w-5 h-5 z-10 drop-shadow-sm" alt="Rank">
                                </div>

                                <div class="flex flex-col min-w-0">
                                    <span class="font-bold text-gray-800 text-base truncate pr-2 group-hover:text-cyan-700 transition-colors">
                                        {{ $s->name }}
                                        @if($s->id == Auth::id())
                                            <span class="ml-1 text-[10px] bg-cyan-600 text-white px-2 py-0.5 rounded-full align-middle">ANDA</span>
                                        @endif
                                    </span>
                                    <span class="text-xs text-gray-500 font-medium bg-gray-100 px-2 py-0.5 rounded-full w-fit">Level {{ $s->level }}</span>
                                </div>
                            </div>

                            <div class="text-right pl-2">
                                <span class="block font-black text-slate-800 text-lg group-hover:text-cyan-600 transition-colors">{{ number_format($s->points) }}</span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">XP Total</span>
                            </div>

                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-10">
                            <p>Belum ada siswa lain di daftar ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- JAVASCRIPT ANIMASI KEMBANG API & KONFETI --}}
    {{-- ========================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // WARNA TEMA: Emas, Biru, Putih (Sesuai tema sekolah/dashboard)
            const colors = ['#FACC15', '#3B82F6', '#ffffff'];

            // 1. EFEK KEMBANG API (FIREWORKS)
            // ----------------------------------------
            const duration = 3 * 1000; // Durasi 3 detik
            const animationEnd = Date.now() + duration;
            const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 50 };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            const interval = setInterval(function() {
                const timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    return clearInterval(interval);
                }

                const particleCount = 50 * (timeLeft / duration);

                // Tembakkan kembang api dari kiri dan kanan secara acak
                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 },
                    colors: colors
                }));
                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 },
                    colors: colors
                }));
            }, 250);


            // 2. EFEK TEROMPET DARI SAMPING (SIDE CANNONS)
            // ----------------------------------------
            // Tembakkan konfeti dari pojok kiri dan kanan bawah
            function shootSideConfetti() {
                const end = Date.now() + (2 * 1000); // 2 Detik tambahan

                (function frame() {
                    confetti({
                        particleCount: 2,
                        angle: 60,
                        spread: 55,
                        origin: { x: 0, y: 0.8 }, // Kiri Bawah
                        colors: colors
                    });
                    confetti({
                        particleCount: 2,
                        angle: 120,
                        spread: 55,
                        origin: { x: 1, y: 0.8 }, // Kanan Bawah
                        colors: colors
                    });

                    if (Date.now() < end) {
                        requestAnimationFrame(frame);
                    }
                }());
            }

            // Jalankan efek terompet sedikit setelah kembang api mulai
            setTimeout(shootSideConfetti, 500);
        });
    </script>

</x-app-layout>
